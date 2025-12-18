import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
import { getMessaging, getToken, onMessage } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

const firebaseConfig = {
    apiKey: "AIzaSyAsvCe4NF3bTH4Ls5wqUWED5l9RQqdPKlw",
    authDomain: "sewa-motor-d826a.firebaseapp.com",
    projectId: "sewa-motor-d826a",
    messagingSenderId: "479125839434",
    appId: "1:479125839434:web:ef0ac9fc5c77c32f60d0b3"
};

const app = initializeApp(firebaseConfig);
const messaging = getMessaging(app);

// 👉 expose ke global (PENTING)
window.messaging = messaging;

async function initFCM() {
    // REGISTER SERVICE WORKER
    const swReg = await navigator.serviceWorker.register('/firebase-messaging-sw.js');
    console.log('✅ SW registered');

    // REQUEST PERMISSION (AMAN)
    const permission = await Notification.requestPermission();
    if (permission !== 'granted') return;

    const token = await getToken(messaging, {
        vapidKey: 'BBIshT94AgmW-tnPZCozkwK9j8Aze319LufxdXyp5kfEvFC1eTMklncTXX8n5SzKFTghG1Du_OBJydOnQVzSgt4',
        serviceWorkerRegistration: swReg
    });

    if (token) {
        console.log('🔥 FCM TOKEN:', token);

        fetch('/admin/save-fcm-token', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ token })
        });
    }
}

// 👉 WAJIB: trigger lewat klik user
document.getElementById('enableNotif')?.addEventListener('click', initFCM);


// RUN
initFCM();

// FOREGROUND NOTIFICATION
onMessage(messaging, (payload) => {
    console.log('🔔 Realtime notif:', payload);

    const badge = document.getElementById('notifBadge');
    const list  = document.getElementById('notifList');

    if (!badge || !list) return;

    let count = parseInt(badge.innerText || 0);
    badge.innerText = count + 1;
    badge.classList.remove('d-none');

    list.insertAdjacentHTML('afterbegin', `
        <a class="dropdown-item d-flex align-items-center" href="${payload.data.url}">
            <div class="mr-3">
                <div class="icon-circle bg-primary">
                    <i class="fas fa-bell text-white"></i>
                </div>
            </div>
            <div>
                <div class="small text-gray-500">Baru saja</div>
                <span class="font-weight-bold">${payload.data.title}</span>
            </div>
        </a>
    `);
});

document.addEventListener('DOMContentLoaded', () => {
    const btn = document.getElementById('enableNotif');
    if (!btn) return;

    btn.addEventListener('click', async () => {
        try {
            await initFCM();

            btn.innerText = 'Notifikasi Aktif';
            btn.classList.remove('btn-primary');
            btn.classList.add('btn-success');
            btn.disabled = true;

        } catch (e) {
            console.error(e);
            alert('Gagal mengaktifkan notifikasi');
        }
    });
});

