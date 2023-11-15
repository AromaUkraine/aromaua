<?php

namespace Modules\Catalog\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class SeoCatalogFeatureEvent
{
    use SerializesModels;

    public $data;

    public $entity;

    public $feature_values = null;
    /**
     * @var mixed|null
     */
    private $country_id;

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
