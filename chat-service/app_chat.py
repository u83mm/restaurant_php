import nltk
import pickle
import numpy as np
import os
import mysql.connector
import random
import threading
from flask import Flask, request, jsonify
from flask_cors import CORS
from tensorflow.keras.models import load_model
from nltk.stem import SnowballStemmer

# Forzamos la descarga dentro del propio script al arrancar
try:
    nltk.data.find('tokenizers/punkt_tab')
except LookupError:
    nltk.download('punkt')
    nltk.download('punkt_tab')

# Configuración inicial
stemmer = SnowballStemmer('spanish')
app = Flask(__name__)
CORS(app)

global model, words, classes

try:
    # Cargar archivos entrenados
    words = pickle.load(open('words.pkl', 'rb'))
    classes = pickle.load(open('classes.pkl', 'rb'))
    model = load_model('model.keras')
except Exception as e:
    print("Aviso: No se encontraron archivos de modelo. Esperando entrenamiento...")
    model = None
    words = []
    classes = []    

def get_db_response(tag):
    """Consulta una respuesta aleatoria en MariaDB basada en el tag predicho"""
    try:
        conn = mysql.connector.connect(
            host = "db",
            user = "admin",
            password = "admin",
            database = "my_database",
            charset = "utf8mb4",
            collation = "utf8mb4_general_ci"
        )

        cursor = conn.cursor()

        # Consulta SQL con JOIN para obtener respuestas or etiqueta
        query = """
            SELECT r.response_text
            FROM responses_ia r
            JOIN intents_ia i ON r.intent_id = i.id
            WHERE i.tag = %s
        """

        cursor.execute(query, (tag,))
        results = cursor.fetchall()
        conn.close()

        if(results):
            return random.choice(results)[0]
        
        return "Lo siento, encontré la intención, pero no hay respuestas configuradas."
    except Exception as e:
        print(f"Error de DB: {e}")
        return "Ups, tuve un problema al consultar mi base de datos."

def clean_up_sentence(sentence):
    sentence_words = nltk.word_tokenize(sentence)
    sentence_words = [stemmer.stem(word.lower()) for word in sentence_words]

    return sentence_words

def bow(sentence, words):
    sentence_words = clean_up_sentence(sentence)
    bag = [0]*len(words)

    for s in sentence_words:
        for i, w in enumerate(words):
            if w == s:
                bag[i] = 1
    
    return(np.array(bag))

@app.route('/chat', methods=['POST'])

def chat():
    data = request.json
    message = data.get("message", "")

    if not message:
        return jsonify({"response": "No he recibido nada..."})
    
    # Predecir intención
    p = bow(message, words)
    res = model.predict(np.array([p]))[0]

    # Filtrar por umbral de confianza
    ERROR_THRESHOLD = 0.72
    results = [[i, r] for i, r in enumerate(res) if r > ERROR_THRESHOLD]
    results.sort(key=lambda x: x[1], reverse=True)

    if results:
        tag = classes[results[0][0]]
        confidence = float(results[0][1]) # Guardamos la probabilidad
        # Buscar respuesta en la base de datos
        response = get_db_response(tag)
    else:
        tag = "unknown"
        confidence = float(res[np.argmax(res)]) # La mejor aunque no llegue al mínimo
        response = "Lo siento, no entiendo qué me quieres decir."
    
    # Guardar log en DB
    try:
        conn = mysql.connector.connect(
            host = "db",
            user = "admin",
            password = "admin",
            database= "my_database",
            charset = "utf8mb4",
            collation = "utf8mb4_general_ci"
        )

        cursor = conn.cursor(dictionary=True)
        query = "INSERT INTO chat_logs (user_message, bot_response, detected_tag, confidence) VALUES(%s, %s, %s, %s)"
        cursor.execute(query, (message, response, tag, confidence))
        conn.commit()
        conn.close()
    except Exception as e:
        print(f"Error guardando log: {e}")

    return jsonify({"response": response, "tag": tag})

def train_model_process():
    """Función interna que ejecuta el entrenamiento completo"""
    print("Iniciando re-entrenamiento...")

    global model, words, classes

    # 1. Cargar datos de la DB (usamos la lógica que utilizamos en Jupyter)
    conn = mysql.connector.connect(
        host = "db",
        user = "admin",
        password = "admin",
        database= "my_database",
        charset = "utf8mb4",
        collation = "utf8mb4_general_ci"
    )

    cursor = conn.cursor(dictionary=True)
    cursor.execute("SELECT id, tag FROM intents_ia")
    intents_db = cursor.fetchall()

    documents = []
    classes = []
    words = []
    ignore_letters = ['?', '!', '¿', '¡', '.', ',']

    for intent in intents_db:
        tag = intent['tag']
        classes.append(tag)
        cursor.execute("SELECT pattern_text FROM patterns_ia WHERE intent_id = %s", (intent['id'],))

        for p in cursor.fetchall():
            w = nltk.word_tokenize(p['pattern_text'])
            words.extend(w)
            documents.append((w, tag))
    
    conn.close()

    # Preprocesamiento
    words = sorted(list(set([stemmer.stem(w.lower()) for w in words if w not in ignore_letters])))
    classes = sorted(list(set(classes)))

    # Guardar pkls (importante: sobreescribimos los actuales)
    pickle.dump(words, open('words.pkl', 'wb'))
    pickle.dump(classes, open('classes.pkl', 'wb'))

    # Crear datos de entrenamiento (X e Y)
    training = []
    output_empty = [0] * len(classes)

    for doc in documents:
        bag = []
        pattern_words = [stemmer.stem(word.lower()) for word in doc[0]]

        for w in words:
            bag.append(1) if w in pattern_words else bag.append(0)
        
        output_row = list(output_empty)
        output_row[classes.index(doc[1])] = 1
        training.append([bag, output_row])
    
    random.shuffle(training)
    train_x = np.array([i[0] for i in training])
    train_y = np.array([i[1] for i in training])

    # Re-entrenar el modelo (usamos la misma arquitectura)
    from tensorflow.keras.models import Sequential
    from tensorflow.keras.layers import Dense, Dropout
    from tensorflow.keras.optimizers import SGD

    new_model = Sequential([
        Dense(128, input_shape=(len(train_x[0]),), activation='relu'),
        Dropout(0.5),
        Dense(64, activation='relu'),
        Dropout(0.5),
        Dense(len(train_y[0]), activation='softmax')
    ])

    sgd = SGD(learning_rate=0.01, decay=1e-6, momentum=0.9, nesterov=True)
    new_model.compile(loss='categorical_crossentropy', optimizer=sgd, metrics=['accuracy'])
    new_model.fit(train_x, train_y, epochs=200, batch_size=5, verbose=0)

    # Guardar y recargar en memoria
    new_model.save('model.keras')
        
    model = new_model
    print("Entrenamiento finalizado con éxito. Modelo actualizado en memoria.")

@app.route('/train', methods=['POST'])

def train():
    # Usamos un hilo (thread) para que la web no se quede colgada esperando
    thread = threading.Thread(target=train_model_process)
    thread.start()

    return jsonify({"message": "Entrenamiento iniciado en segundo plano..."})


if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)