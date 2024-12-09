from flask import Flask, request, jsonify
import tensorflow as tf
import pickle
import numpy as np
import re

# Load the trained model and tokenizer
model = tf.keras.models.load_model('sentiment_model.keras')
with open('tokenizer.pkl', 'rb') as f:
    tokenizer = pickle.load(f)

# Text preprocessing function
def preprocess_text(text):
    return re.sub(r'[^\w\s]', '', text.lower())

# Create Flask app
app = Flask(__name__)

@app.route('/analyze', methods=['POST'])
def analyze_sentiment():
    data = request.json
    feedbacks = data.get('feedbacks', [])
    results = []

    for feedback in feedbacks:
        feedback_text = preprocess_text(feedback['FeedbackMessage'])
        
        # Debug: Print original and preprocessed text
        print(f"Original: {feedback['FeedbackMessage']}, Preprocessed: {feedback_text}")
        
        # Preprocess feedback message
        tokenized = tokenizer.texts_to_sequences([feedback_text])
        padded = tf.keras.preprocessing.sequence.pad_sequences(tokenized, maxlen=100)
        
        # Debug: Print tokenized and padded input
        print(f"Tokenized: {tokenized}, Padded: {padded}")

        # Predict sentiment
        prediction = model.predict(padded)[0]
        
        # Debug: Print prediction probabilities
        print(f"Prediction Probabilities: {prediction}")

        sentiment_label = ['Negative', 'Neutral', 'Positive'][np.argmax(prediction)]

        results.append({
            'FeedbackID': feedback['FeedbackID'],
            'SentimentLabel': sentiment_label,
            'Confidence': float(np.max(prediction))
        })

    return jsonify(results)

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
