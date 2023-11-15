<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\FeatureKind;

class UpdateFeatureValueEvent
{
    use SerializesModels;

    /**
     * @var FeatureKind
     */
    public $entity;
    public $request;

    /**
     * Create a new event instance.
     *
     * @param FeatureKind $kind
     * @param $request
     */
    public function __construct($entity, $request)
    {
        //
        $this->entity = $entity;
        $this->request = $request;
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
