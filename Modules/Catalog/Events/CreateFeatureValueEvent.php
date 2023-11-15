<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\FeatureKind;

class CreateFeatureValueEvent
{
    use SerializesModels;

    /**
     * @var FeatureKind
     */
    public $kind;
    public $request;

    /**
     * Create a new event instance.
     *
     * @param FeatureKind $kind
     * @param $request
     */
    public function __construct(FeatureKind $kind, $request)
    {
        //
        $this->kind = $kind;
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
