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
import seaborn as sns

# Load the dataset
data = pd.read_csv('feedbacks.csv')

# Ensure the 'Sentiment' column has valid values
valid_labels = ['Neutral', 'Negative', 'Positive']

# Debug: Initial dataset
print("Initial Dataset:")
print(data.head())

# Remove rows with invalid or NaN Sentiment labels
data = data.dropna(subset=['Sentiment'])
data = data[data['Sentiment'].isin(valid_labels)]

# Raise error if the dataset is empty after preprocessing
if data.empty:
    raise ValueError("The dataset is empty after preprocessing. Please check your input data.")

# Encode sentiment labels
label_encoder = LabelEncoder()
data['Sentiment'] = label_encoder.fit_transform(data['Sentiment'])
print("Encoded Classes:", label_encoder.classes_)

# Debug: Check class distribution
print("Class Distribution:")
print(data['Sentiment'].value_counts())

# Visualize class distribution
plt.figure(figsize=(8, 5))
sns.countplot(x=data['Sentiment'], palette='Set2')
plt.title("Class Distribution")
plt.xlabel("Sentiment Class")
plt.ylabel("Count")
plt.show()

# Preprocess the text (convert to lowercase, remove punctuation)
data['FeedbackMessage'] = data['FeedbackMessage'].apply(
    lambda x: re.sub(r'[^\w\s]', '', str(x).lower())
)

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

# Debug: View the model summary
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
print(classification_report(y_test, y_pred, target_names=label_encoder.classes_))

# Save the model and tokenizer
model.save('sentiment_model.keras')

with open('tokenizer.pkl', 'wb') as f:
    pickle.dump(tokenizer, f)

# Verify tokenizer saving
with open('tokenizer.pkl', 'rb') as f:
    loaded_tokenizer = pickle.load(f)
print("Tokenizer reloaded successfully:", loaded_tokenizer.word_index != {})

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
