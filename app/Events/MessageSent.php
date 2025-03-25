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
    public $reservationId;

    public function __construct($message, $reservationId)
    {
        $this->message = $message;
        $this->reservationId = $reservationId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->reservationId);
    }

    public function broadcastWith()
    {
        return [
            'message' => $this->message,
        ];
    }
}