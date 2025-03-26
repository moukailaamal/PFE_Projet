import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Configuration Axios
window.axios = axios;
window.axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]')?.content || ''
};

// Configuration Pusher/Echo
window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    forceTLS: true,
    wsHost: window.location.hostname,
    wsPort: 6001,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-Token': document.head.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    }
});

// Debug (à désactiver en production)
if (process.env.NODE_ENV === 'development') {
    window.Echo.connector.pusher.connection.bind('state_change', (states) => {
        console.log('Pusher connection state:', states.current);
    });
}