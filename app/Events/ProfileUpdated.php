<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Contracts\Events\ShouldDispatchAfterCommit;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class ProfileUpdated implements ShouldBroadcastNow, ShouldDispatchAfterCommit
{
    use InteractsWithSockets, SerializesModels;

    public User $user;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('user.' . $this->user->id);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'profile.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'user' => $this->user->only(['id', 'name', 'email']),
        ];
    }
}
