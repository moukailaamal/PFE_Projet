<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $message;
    /**
     * Create a new event instance.
     */
    public function __construct($message)
    {
        $this->message=$message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
  
     public function broadcastWith()
     {
         return [
             'message' => $this->message,
             'sender_name' => $this->message->sender->first_name,
             'sender_photo' => $this->message->sender->photo ? 
                              asset('storage/' . $this->message->sender->photo) : 
                              asset('images/default-avatar.png'),
             'sender_id' => $this->message->sender_id,
             'receiver_id' => $this->message->receiver_id
         ];
     }
     
     public function broadcastOn()
     {
         return new Channel('chat-room'); // Keeping the channel name as chat-room
     }

}