
///  /chat/chat-handler

// Envoi de message
document.getElementById('message-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value.trim();

    if (message) {
        axios.post('/send-message', { message })
            .then(() => {
                appendMessage(message, true); // Afficher le message envoyé
                messageInput.value = '';
            })
            .catch(error => console.error('Error:', error));
    }
});

// Réception de message
window.Echo.channel('public-chat')
    .listen('.MessageSent', (data) => {
        appendMessage(data.message, false); // false = message reçu
    });

function appendMessage(message, isSentByMe) {
    const messagesContainer = document.getElementById('chat-messages');
    const messageDiv = document.createElement('div');
    
    messageDiv.className = isSentByMe ? 'right message' : 'left message';
    messageDiv.innerHTML = isSentByMe 
        ? `<p>${message}</p><img src="/images/users/michael-gough.png" alt="You">`
        : `<img src="/images/users/leslie-livingston.png" alt="User"><p>${message}</p>`;
    
    messagesContainer.appendChild(messageDiv);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}