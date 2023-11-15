<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class FeatureModifyCopyProductFeatureListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        try {
            \DB::beginTransaction();


            if (isset($event->product) && $event->product):

                // находим основной
                $parent = Product::where('id', $event->product->parent_product_id)->first();

                $data = [];
                // берем хар-ки у родителя исключая те что под модификаций
                $parent->entity_features
                    ->whereNotNull('feature_value_id')
                    ->where('feature_id', '!=', $event->product->category->modify_feature)
                    ->groupBy('feature_id')
                    ->map(function ($collection, $key) use (&$data) {
                        $collection->each(function ($value, $k) use (&$data, $key) {
                            $data[$key][$k] = $value->feature_value_id;
                        });
                    });


                $childes = Product::where('parent_product_id', $parent->id)
                    ->where('id', '!=', $parent->id)->get();

                $childes->each(function ($child) use ($data, $parent, $event) {

                    // берем хар-ки у наследников только те что под модификаций
                    $child->entity_features
                        ->whereNotNull('feature_value_id')
                        ->where('feature_id', $parent->category->modify_feature)
                        ->groupBy('feature_id')
                        ->map(function ($collection, $key) use(&$data){
                            $collection->each(function ($value, $k) use(&$data, $key){
                                $data[$key][$k] = $value->feature_value_id;
                            });
                        });
                    $event->product = $child;
                    $event->feature_values = $data;

                    (new ProductFeatureUpdateFeatureValueListener())->handle($event);

                });

            endif;

            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }
    }

}
