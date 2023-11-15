<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class JoinProductToParentProductListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {





        $event->product->update([
            'parent_product_id' => $event->data['parent_product_id'],
        ]);


        // собираем хар-ки родителя и присваиваем наследнику исключая модификацию
        if($event->data['copy']):

            $data = [];

            // берем хар-ки у родителя исключая те что под модификаций
            $event->product->parent->entity_features
                ->whereNotNull('feature_value_id')
                ->where('feature_id','!=', $event->product->category->modify_feature)
                ->groupBy('feature_id')
                ->map(function ($collection, $key) use(&$data){
                    $collection->each(function ($value, $k) use(&$data, $key){
                        $data[$key][$k] = $value->feature_value_id;
                    });
                });



            // берем хар-ки у товара только те что под модификаций
            $event->product->entity_features
                ->whereNotNull('feature_value_id')
                ->where('feature_id', $event->product->category->modify_feature)
                ->groupBy('feature_id')
                ->map(function ($collection, $key) use(&$data){
                    $collection->each(function ($value, $k) use(&$data, $key){
                        $data[$key][$k] = $value->feature_value_id;
                    });
                });

            $event->feature_values = $data;

            (new ProductFeatureUpdateFeatureValueListener())->handle($event);
        endif;

    }
}
