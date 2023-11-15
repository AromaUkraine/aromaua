<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\SeoCatalog;

class SeoCatalogCreateEvent
{
    use SerializesModels;

    public $entity;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param $entity
     * @param $data
     */
    public function __construct( $data, $entity)
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
