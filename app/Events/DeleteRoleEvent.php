<?php

namespace App\Events;

use App\Models\Role;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeleteRoleEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Role
     */
    public $role;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Role $role)
    {
        //
        $this->role = $role;
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
