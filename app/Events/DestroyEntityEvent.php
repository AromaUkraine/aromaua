<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DestroyEntityEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $entity;
    public $softDelete;
    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param $softDelete
     */
    public function __construct($entity, $softDelete = null )
    {
        //
        $this->entity = $entity;

        $this->softDelete = $softDelete ?? config('app.softDelete');
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
