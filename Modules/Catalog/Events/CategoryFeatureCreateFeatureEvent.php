<?php

namespace Modules\Catalog\Events;


use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class CategoryFeatureCreateFeatureEvent
{
    use SerializesModels;

    public $used;

    public $entity;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param $entity
     */
    public function __construct(Request $request, $entity)
    {
        $this->used = $request->used ?? null;
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
