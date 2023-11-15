<?php

namespace Modules\Gallery\Events;

use Illuminate\Queue\SerializesModels;

class CreatePhotoGalleryEvent
{
    use SerializesModels;

    public $data;
    public $entity;

    /**
     * Create a new event instance.
     *
     * @param $data
     * @param $entity
     */
    public function __construct($data, $entity)
    {
        $this->data = $data;
        $this->entity = $entity;
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
