import pandas as pd
import numpy as np
import re
from sklearn.model_selection import train_test_split
from sklearn.preprocessing import LabelEncoder
from tensorflow.keras.preprocessing.text import Tokenizer
from tensorflow.keras.preprocessing.sequence import pad_sequences
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Embedding, LSTM, Dense, Dropout, Bidirectional
from tensorflow.keras.callbacks import EarlyStopping
from sklearn.metrics import classification_report
import matplotlib.pyplot as plt
import pickle

# Load the dataset
data = pd.read_csv('feedbacks.csv')

# Ensure the 'Sentiment' column has valid values
valid_labels = [0, 1, 2]  # Only allow these labels: Negative (0), Neutral (1), Positive (2)
if data.empty:
    raise ValueError("The dataset is empty after preprocessing. Please check your input data.")

if 'Sentiment' not in data.columns:
    raise ValueError("The 'Sentiment' column is missing in the dataset.")

# Remove invalid labels if any
data = data[data['Sentiment'].isin(valid_labels)]

# Preprocess the text (convert to lowercase, remove punctuation)
data['FeedbackMessage'] = data['FeedbackMessage'].apply(lambda x: re.sub(r'[^\w\s]', '', str(x).lower()))

# Encode sentiment labels
label_encoder = LabelEncoder()
data['Sentiment'] = label_encoder.fit_transform(data['Sentiment'])  # Convert labels to numeric values

# Check class distribution
print("Class Distribution:")
print(data['Sentiment'].value_counts())

# Split the data into training and testing sets
X_train, X_test, y_train, y_test = train_test_split(
    data['FeedbackMessage'], data['Sentiment'], test_size=0.2, random_state=42
)

# Tokenize the text
tokenizer = Tokenizer(num_words=5000)  # Keep the top 5000 words
tokenizer.fit_on_texts(X_train)

X_train = tokenizer.texts_to_sequences(X_train)
X_test = tokenizer.texts_to_sequences(X_test)

# Pad sequences to ensure equal length
X_train = pad_sequences(X_train, maxlen=100)
X_test = pad_sequences(X_test, maxlen=100)

# Define the model
model = Sequential([
    Embedding(input_dim=5000, output_dim=128, input_length=100),
    Bidirectional(LSTM(64, return_sequences=True)),
    Dropout(0.5),
    Bidirectional(LSTM(32)),
    Dense(3, activation='softmax')  # 3 classes: Positive, Neutral, Negative
])

# Compile the model
model.compile(loss='sparse_categorical_crossentropy', optimizer='adam', metrics=['accuracy'])

# View the model summary
print("Model Summary:")
model.summary()

# Add early stopping to prevent overfitting
early_stopping = EarlyStopping(monitor='val_loss', patience=3, restore_best_weights=True)

# Train the model
history = model.fit(
    X_train, y_train,
    validation_data=(X_test, y_test),
    epochs=20,
    batch_size=32,
    callbacks=[early_stopping]
)

# Evaluate the model
loss, accuracy = model.evaluate(X_test, y_test)
print(f"Test Accuracy: {accuracy * 100:.2f}%")

# Generate a classification report
y_pred = model.predict(X_test).argmax(axis=1)
print("Classification Report:")
print(classification_report(y_test, y_pred, target_names=['Negative', 'Neutral', 'Positive']))

# Save the model and tokenizer
model.save('sentiment_model.h5')

with open('tokenizer.pkl', 'wb') as f:
    pickle.dump(tokenizer, f)

# Plot training history
plt.figure(figsize=(12, 6))

# Plot accuracy
plt.subplot(1, 2, 1)
plt.plot(history.history['accuracy'], label='Train Accuracy')
plt.plot(history.history['val_accuracy'], label='Validation Accuracy')
plt.title('Accuracy')
plt.legend()

# Plot loss
plt.subplot(1, 2, 2)
plt.plot(history.history['loss'], label='Train Loss')
plt.plot(history.history['val_loss'], label='Validation Loss')
plt.title('Loss')
plt.legend()

plt.show()
