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

# Cargar archivos entrenados
words = pickle.load(open('words.pkl', 'rb'))
classes = pickle.load(open('classes.pkl', 'rb'))
model = load_model('model.keras')

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

		return "Ups, tuve un problema al consultar mi base de datos"

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
	ERROR_THRESHOLD = 0.61
	results = [[i, r] for i, r in enumerate(res) if r > ERROR_THRESHOLD]
	results.sort(key=lambda x: x[1], reverse=True)

	if results:
		tag = classes[results[0][0]]
		# Buscar respuesta en la DB
		response = get_db_response(tag)
	else:
		tag = "unknown"
		response = "Lo siento, no entiendo qué me quieres decir."

	return jsonify({"response": response, "tag": tag if results else "unknown"})

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)

