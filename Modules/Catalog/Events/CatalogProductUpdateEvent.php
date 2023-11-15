<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\Product;

class CatalogProductUpdateEvent
{
    use SerializesModels;

    public $data;
    public $product;
    /**
     * Create a new event instance.
     *
     * @param $data
     * @param Product $product
     */
    public function __construct($data, Product $product)
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
