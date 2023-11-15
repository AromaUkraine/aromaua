<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductFeatureCreateFeatureValueListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        $feature_values = $event->feature_values ?? [];
        $product = $event->product ?? null;

        foreach ($feature_values as $feature_id => $values) :
            foreach ($values as $feature_value_id)  :
                  $product->entity_features()->create([
                     'feature_id' => (int)$feature_id,
                     'feature_value_id' => (int)$feature_value_id
                 ]);
            endforeach;
        endforeach;

    }
}
