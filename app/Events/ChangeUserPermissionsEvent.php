<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChangeUserPermissionsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $permissions;
    public $user;

    /**
     * ChangeUserPermissionsEvent constructor.
     * @param User $user
     * @param array $permissions
     */
    public function __construct(User $user, array $permissions)
    {
        $this->user = $user;
        $this->permissions = $permissions;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
