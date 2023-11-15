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

class ChangeRolePermissionsEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Role
     */
    public $role;
    public $permissions;


    /**
     * ChangeRolePermissionsEvent constructor.
     * @param Role $role
     * @param $permissions
     */
    public function __construct(Role $role, $permissions)
    {

        $this->role = $role;
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
