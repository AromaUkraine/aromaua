<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;

class FeatureModifyChangeParentProductEvent
{
    use SerializesModels;

    public $parent_before_id;
    public $parent_new_id;

    public $product;

    public $childes;

    /**
     * Create a new event instance.
     *
     * @param $parent_before_id
     * @param $parent_new_id
     */
    public function __construct($parent_before_id, $parent_new_id)
    {
        //
        $this->parent_before_id = $parent_before_id;
        $this->parent_new_id = $parent_new_id;
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
