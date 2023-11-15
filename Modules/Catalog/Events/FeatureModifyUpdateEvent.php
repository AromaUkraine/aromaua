<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\Product;

class FeatureModifyUpdateEvent
{
    use SerializesModels;

    /**
     * @var Product
     */
    public $product;

    public $data;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param $data
     */
    public function __construct(Product $product, $data)
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
