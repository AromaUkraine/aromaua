<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;

class JoinProductToParentProductEvent
{
    use SerializesModels;

    public $product;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param $product
     * @param $data
     */
    public function __construct($product, $data)
    {
        $this->product = $product;
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
