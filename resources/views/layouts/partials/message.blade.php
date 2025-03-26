<div class="message flex {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
    <div class="{{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }} 
                rounded-lg p-3 max-w-xs">
        <div class="font-semibold">
            {{ $message->sender_id == auth()->id() ? 'Vous' : $message->sender->name }}
        </div>
        <div class="content">{{ $message->content }}</div>
        <div class="text-xs opacity-70 mt-1">
            {{ $message->send_date->format('H:i') }}
            @if($message->sender_id == auth()->id())
                • {{ $message->is_read ? 'Lu' : 'Envoyé' }}
                @isset($message->reservation_id)
                    • Réservation #{{ $message->reservation_id }}
                @endisset
            @endif
        </div>
    </div>
</div>