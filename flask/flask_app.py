from flask import Flask, request, jsonify
import tensorflow as tf
import pickle
import numpy as np

# Load the trained model and tokenizer
model = tf.keras.models.load_model('sentiment_model.h5')
with open('tokenizer.pkl', 'rb') as f:
    tokenizer = pickle.load(f)

# Create Flask app
app = Flask(__name__)

@app.route('/analyze', methods=['POST'])
def analyze_sentiment():
    data = request.json
    feedbacks = data.get('feedbacks', [])
    results = []

    for feedback in feedbacks:
        # Preprocess feedback message
        tokenized = tokenizer.texts_to_sequences([feedback['FeedbackMessage']])
        padded = tf.keras.preprocessing.sequence.pad_sequences(tokenized, maxlen=100)

        # Predict sentiment
        prediction = model.predict(padded)[0]
        sentiment_label = ['Negative', 'Neutral', 'Positive'][np.argmax(prediction)]

        results.append({
            'FeedbackID': feedback['FeedbackID'],
            'SentimentLabel': sentiment_label,
            'Confidence': float(np.max(prediction))
        })

    return jsonify(results)

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
