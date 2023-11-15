<?php

namespace Modules\Catalog\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class ProductFeatureCreateFeatureValueEvent
{
    use SerializesModels;

    /**
     * @var mixed|null
     */
    public $feature_values;

    public $product;

    /**
     * Create a new event instance.
     *
     * @param Request $request
     * @param $product
     */
    public function __construct(Request $request, $product)
    {
        $this->feature_values = $request->feature_values ?? null;
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
