import './bootstrap';

const chatContainer = document.getElementById('chat-container');
const reservationId = chatContainer.dataset.reservationId;
const currentUserId = parseInt(chatContainer.dataset.currentUserId);
const receiverId = parseInt(chatContainer.dataset.receiverId);

// Déterminer le canal approprié
let channel;
if (reservationId) {
    // Mode réservation
    channel = `chat.reservation.${reservationId}`;
} else {
    // Mode conversation directe - on trie les IDs pour avoir un canal cohérent
    const userIds = [currentUserId, receiverId].sort((a, b) => a - b);
    channel = `chat.direct.${userIds.join('-')}`;
}

// Écoute des nouveaux messages
window.Echo.private(channel)
    .listen('MessageSent', (data) => {
        addMessage(data, data.sender_id !== currentUserId);
        if (data.receiver_id === currentUserId) {
            markAsRead([data.id]);
        }
    });

// Fonction pour ajouter un message
function addMessage(message, isReceived) {
    const messagesContainer = document.getElementById('messages');
    const messageElement = document.createElement('div');
    
    messageElement.className = `flex ${isReceived ? 'justify-start' : 'justify-end'} mb-3`;
    messageElement.innerHTML = `
        <div class="${isReceived ? 'bg-gray-200' : 'bg-blue-500 text-white'} 
                    rounded-lg p-3 max-w-xs shadow-sm">
            <div class="font-semibold flex items-center">
                ${isReceived ? message.sender.name : 'Vous'}
                ${!isReceived && message.is_read ? 
                    '<svg class="w-4 h-4 ml-1 text-blue-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L9 12.586l7.293-7.293a1 1 0 011.414 1.414l-8 8z"/></svg>' : ''}
            </div>
            <div class="mt-1">${message.content}</div>
            <div class="text-xs opacity-70 mt-2 flex items-center">
                ${new Date(message.send_date).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                ${!isReceived ? `• ${message.is_read ? 'Lu' : 'Envoyé'}` : ''}
                ${message.reservation_id ? `• Rés #${message.reservation_id}` : ''}
            </div>
        </div>
    `;
    
    messagesContainer.appendChild(messageElement);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Marquer comme lu
function markAsRead(messageIds) {
    axios.post('/messages/mark-as-read', { 
        message_ids: messageIds,
        _token: document.querySelector('meta[name="csrf-token"]').content
    });
}

// Gestion de l'envoi de message
const messageForm = document.getElementById('message-form');
if (messageForm) {
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const input = this.querySelector('input[name="content"]');
        const message = input.value.trim();
        
        if (message) {
            const formData = {
                content: message,
                receiver_id: this.querySelector('input[name="receiver_id"]').value,
                _token: document.querySelector('meta[name="csrf-token"]').content
            };
            
            // Ajouter reservation_id seulement si présent
            if (reservationId) {
                formData.reservation_id = reservationId;
            }
            
            axios.post('/send-message', formData)
                .then(() => input.value = '')
                .catch(error => console.error('Error:', error));
        }
    });
}