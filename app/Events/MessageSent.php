<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $channelType; // 'reservation' ou 'direct'
    public $channelIdentifier;

    public function __construct($message, $channelType, $channelIdentifier = null)
    {
        $this->message = $message;
        $this->channelType = $channelType;
        $this->channelIdentifier = $channelIdentifier;
    }

    public function broadcastOn()
    {
        if ($this->channelType === 'reservation') {
            return new PrivateChannel('chat.reservation.' . $this->channelIdentifier);
        } else {
            // Pour les messages directs, on trie les IDs pour avoir un canal cohérent
            $userIds = [auth()->id(), $this->message->receiver_id];
            sort($userIds);
            return new PrivateChannel('chat.direct.' . implode('-', $userIds));
        }
    }

    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'content' => $this->message->content,
            'sender' => $this->message->sender,
            'receiver_id' => $this->message->receiver_id,
            'send_date' => $this->message->send_date,
            'is_read' => $this->message->is_read,
            'message_type' => $this->message->message_type,
            'channel_type' => $this->channelType,
            'reservation_id' => $this->message->reservation_id
        ];
    }
}