import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

window.Echo.private('notifications' + userId)
    .notification(function(message) {
        let c = Number($('#unread-count').text())
        c++
        $('#unread-count').text(c)

        $('#n-list').prepend(`<a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i>
            ${message.title}
            <span class="float-right text-muted text-sm">now</span>
        </a>
        <div class="dropdown-divider"></div>`);

        $(document).Toasts('create', {
            title: message.title,
            body: message.body,
            animation: true,
            autohide: true,
            delay: 2000
          });
    
    });