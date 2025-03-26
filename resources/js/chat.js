export function initializeChat() {
    const chatContainer = document.getElementById('chat-container');
    if (!chatContainer) return;

    const reservationId = chatContainer.dataset.reservationId;
    const currentUserId = chatContainer.dataset.currentUserId;
    const receiverId = chatContainer.dataset.receiverId;

    // Canal réservation
    if (reservationId) {
        window.Echo.private(`chat.reservation.${reservationId}`)
            .listen('MessageSent', (data) => {
                console.log('Nouveau message (réservation):', data);
                // Traitement du message...
            });
    }
    // Canal direct
    else if (receiverId) {
        const sortedIds = [currentUserId, receiverId].sort((a, b) => a - b);
        window.Echo.private(`chat.direct.${sortedIds.join('-')}`)
            .listen('MessageSent', (data) => {
                console.log('Nouveau message (direct):', data);
                // Traitement du message...
            });
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', initializeChat);