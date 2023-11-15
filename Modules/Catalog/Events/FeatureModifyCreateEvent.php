<?php

namespace Modules\Catalog\Events;

use Illuminate\Queue\SerializesModels;
use Modules\Catalog\Entities\Product;

class FeatureModifyCreateEvent
{
    use SerializesModels;

    public $data;

    public $product;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param array $data
     */
    public function __construct(Product $product, array $data)
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
