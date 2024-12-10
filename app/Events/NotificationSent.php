<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class NotificationSent implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        Log::info('Broadcasting event with message: ', $message); // Log the message being broadcast
        $this->message = $message;
    }

    public function broadcastOn()
    {
        // You can use a private channel if necessary for authenticated users
        return new Channel('notifications');
    }

    public function broadcastWith()
    {
        // You can now return dynamic data based on the incoming $message
        return [
            'id' => '1',
            'avatar' => 'http://[::1]:5173/resources/images/profiles/profile-1.png',
            'avatarName' => 'RM',
            'title' => 'Hello world',
            'subtitle' => 'Welcome to bidflow',
            'time' => 'just now',
            'isSeen' => false,
        ];
    }
}
