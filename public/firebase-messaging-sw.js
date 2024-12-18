// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
  apiKey: "AIzaSyA_Fj0RAUYZ2O7JuAVGfQFue5xkC7Y5t24",
  authDomain: "notif-push-e8316.firebaseapp.com",
  projectId: "notif-push-e8316",
  storageBucket: "notif-push-e8316.appspot.com",
  messagingSenderId: "123246185063",
  appId: "1:123246185063:web:bc242678e6f96c722822c2",
  measurementId: "G-2KNZPFX21X"
});

// Retrieve an instance of Firebase Messaging so that it can handle background
// messages.
const messaging = firebase.messaging();
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);
  
    // Extracting notification data
    const notificationData = payload.notification;
    const notificationTitle = notificationData.title;
    const notificationOptions = {
      body: notificationData.body,
      icon: 'assets/img/logo/pnp-logo.png', // Fallback icon, adjust the path as needed
      image: notificationData.image, // Large image from payload
      // You can add more options here as needed
    };
  
    // Show the custom notification
    self.registration.showNotification(notificationTitle, notificationOptions);
});