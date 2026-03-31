import nltk

# Forzamos la descarga dentro del propio script al arrancar
try:
	nltk.data.find('tokenizers/punkt_tab')
except LookupError:
	nltk.download('punkt')
	nltk.download('punkt_tab')

import pickle
import numpy as np
import json
import os
from flask import Flask, request, jsonify
from flask_cors import CORS
from tensorflow.keras.models import load_model
from nltk.stem import SnowballStemmer

# Configuración inicial
stemmer = SnowballStemmer('spanish')
app = Flask(__name__)
CORS(app)

# Cargar archivos entrenados
words = pickle.load(open('words.pkl', 'rb'))
classes = pickle.load(open('classes.pkl', 'rb'))
model = load_model('model.keras')
intents = json.loads(open('intents.json', encoding='utf-8').read())

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
	ERROR_THRESHOLD = 0.25
	results = [[i, r] for i, r in enumerate(res) if r > ERROR_THRESHOLD]
	results.sort(key=lambda x: x[1], reverse=True)

	if results:
		tag = classes[results[0][0]]
		# Buscar respuesta aleatoria en el JSON de intenciones
		for i in intents['intents']:
			if i['tag'] == tag:
				import random
				response = random.choice(i['responses'])
				break
	else:
		response = "Lo siento, no entiendo qué me quieres decir."

	return jsonify({"response": response, "tag": tag if results else "unknown"})

if __name__ == "__main__":
    app.run(host='0.0.0.0', port=5000)

