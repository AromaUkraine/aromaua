<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;

class ChangeEntityFeatureEvent
{
    use SerializesModels;

    /**
     * @var array
     */
    public $feature;
    /**
     * @var object
     */
    public $entity;
    /**
     * @var string
     */
    public $status;


    /**
     * Create a new event instance.
     *
     * @param array $feature
     * @param object $entity
     * @param string $status
     */
    public function __construct(object $entity, array $feature, string $status)
    {
        $this->feature = $feature;
        $this->entity = $entity;
        $this->status = $status;
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
