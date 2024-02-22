// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here. Other Firebase libraries
// are not available in the service worker.
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/8.10.1/firebase-messaging.js');

// Initialize the Firebase app in the service worker by passing in
// your app's Firebase config object.
// https://firebase.google.com/docs/web/setup#config-object
firebase.initializeApp({
    apiKey: "AIzaSyALSiPzYneokQ4vA8eQNkbcuuud8lPzNpg",
    authDomain: "push-notif-16cb3.firebaseapp.com",
    projectId: "push-notif-16cb3",
    storageBucket: "push-notif-16cb3.appspot.com",
    messagingSenderId: "182663808079",
    appId: "1:182663808079:web:1e41d21168a7073c58d63a",
    measurementId: "G-JXC6YLCSYQ"
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