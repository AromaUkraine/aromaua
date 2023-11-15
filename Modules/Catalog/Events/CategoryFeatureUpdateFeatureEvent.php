<?php

namespace Modules\Catalog\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class CategoryFeatureUpdateFeatureEvent
{
    use SerializesModels;

    /**
     * @var mixed|null
     */
    public $used;
    /**
     * @var mixed|null
     */
    public $available;

    public $entity;


    public $request;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param $entity
     */
    public function __construct(Request $request, $entity)
    {
        $this->request = $request->all();
        $this->used = $request->used ?? null;
        $this->available = $request->available ?? null;
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
