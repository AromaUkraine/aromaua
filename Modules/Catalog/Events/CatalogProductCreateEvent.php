<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\Product;

class CatalogProductCreateEvent
{
    use SerializesModels;

    public $data;
    public $product;

    /**
     * Create a new event instance.
     *
     * @param $product
     * @param $data
     */
    public function __construct($product, $data)
    {
        //
        $this->data = $data;

        $this->product = $product;
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
