// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here.
// Other Firebase libraries are not available in the service worker.
// importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-app.js");
// importScripts("https://www.gstatic.com/firebasejs/7.16.1/firebase-messaging.js",);
importScripts('https://www.gstatic.com/firebasejs/9.2.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.2.0/firebase-messaging-compat.js');
 


if (firebase.messaging.isSupported()) {
    // Initialize the Firebase app in the service worker by passing in the
    // messagingSenderId.
    firebase.initializeApp({
        'messagingSenderId': "1005936827413",
        'apiKey': "AIzaSyAu00t4wAHnmdrPfFpbMhKvsaU96f-l-r4",
        'projectId': "rouh-app",	
        'appId': "1:1005936827413:web:ff97a7ec1b190354f3421c",


  
        'authDomain': 'rouh-app.firebaseapp.com',
        'databaseURL': 'https://rouh-app.firebaseio.com',
       
        'storageBucket': 'project-id.appspot.com',
  
    });

    // Retrieve an instance of Firebase Messaging so that it can handle background messages.
    const messaging = firebase.messaging();

    messaging.onBackgroundMessage(function (payload) {
        console.log(
            "[firebase-messaging-sw.js] Received background message ",
            payload,
        );
      //  const { title, body, image, username } = payload.data;
      
        // Customize notification here
        const notificationTitle =payload.data.title|| "Background Message Title";
        const notificationOptions = {
            body:payload.data.body||"Background Message body." ,
            icon: payload.data.image|| "/itwonders-web-logo.png",
        };
       
        if (payload.data.username) {
            notificationOptions.body += ` - Sent by ${payload.data.username}`;
        }
        if (payload.data.id) {
            notificationOptions.body += ` - Sent by ${payload.data.id}`;
           alert('id='+payload.data.id);
        }
        return self.registration.showNotification(
            notificationTitle,
            notificationOptions,
        );
    });
}