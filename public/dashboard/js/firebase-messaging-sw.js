importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging-compat.js');

firebase.initializeApp({
    apiKey: "AIzaSyAsvCe4NF3bTH4Ls5wqUWED5l9RQqdPKlw",
    authDomain: "sewa-motor-d826a.firebaseapp.com",
    projectId: "sewa-motor-d826a",
    storageBucket: "sewa-motor-d826a.appspot.com",
    messagingSenderId: "479125839434",
    appId: "1:479125839434:web:ef0ac9fc5c77c32f60d0b3"
});

const messaging = firebase.messaging();
