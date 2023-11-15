<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateEntityColorSchemeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var object
     */
    public $entity;

    /**
     * @var object
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param object $entity
     * @param array $request
     */
    public function __construct(object $entity, array $request)
    {
        $this->entity = $entity;
        $this->request = $request;
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
