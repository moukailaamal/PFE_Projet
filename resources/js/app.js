import './bootstrap';

// Wait for the DOM to load
document.addEventListener('DOMContentLoaded', function () {
    // Listen for new messages
    window.Echo.channel('chat')
        .listen('.message.sent', (data) => {
            const messagesList = document.getElementById('messages');
            if (messagesList) {
                const li = document.createElement('li');
                li.textContent = `${data.message.user.name}: ${data.message.message}`;
                messagesList.appendChild(li);
            }
        });
});