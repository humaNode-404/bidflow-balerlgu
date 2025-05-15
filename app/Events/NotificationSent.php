<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class NotificationSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // You can use a private channel if necessary for authenticated users
        return new Channel('notifications');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.sent';
    }

    public function broadcastWith()
    {
        // You can now return dynamic data based on the incoming $message
        return [
            'id' => '1',
            'avatar' => '/storage/avatars/avatar-9.png',
            'avatarName' => 'RM',
            'title' => 'Hello world',
            'subtitle' => 'Welcome to bidflow',
            'time' => 'just now',
            'isSeen' => false,
        ];
    }
}
