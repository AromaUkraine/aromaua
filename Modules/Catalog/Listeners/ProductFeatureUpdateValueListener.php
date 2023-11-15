<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductFeatureUpdateValueListener
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
        $product = $event->product ?? null;

        foreach ($values as $feature_id => $value) :
            $record = $product->entity_features->where('feature_id', $feature_id)->first();

            // если нет $record - создаем новую
            if (!$record) :
                $product->entity_features()->create(['feature_id' => $feature_id, 'value' => $value]);
            // если есть $record - обновляем
            else :
                $record->update(['value' => $value]);
            endif;

        endforeach;
    }
}
