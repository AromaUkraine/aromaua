<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\Product;

class FeatureModifyCopyProductFeatureEvent
{
    use SerializesModels;

    /**
     * @var Product
     */
    public $product;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
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
