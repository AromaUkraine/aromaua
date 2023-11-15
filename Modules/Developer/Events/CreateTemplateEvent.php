<?php

namespace Modules\Developer\Events;

use Illuminate\Queue\SerializesModels;

class CreateTemplateEvent
{
    use SerializesModels;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param $data
     */
    public function __construct( $data )
    {
        $this->data = $data;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
