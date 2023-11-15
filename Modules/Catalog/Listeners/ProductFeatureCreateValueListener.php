<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductFeatureCreateValueListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $values = $event->values ?? [];
        $product = $event->product;

        foreach ($values as $feature_id => $val) :
            $product->entity_features()->create([
                'feature_id' => (int)$feature_id,
                'value' => $val
            ]);
        endforeach;

    }
}
