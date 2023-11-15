<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryFeatureUpdateFeatureListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        $used = collect(json_decode($event->used, true) ?? []);
        $available = collect(json_decode($event->available, true) ?? []);

        $entity = $event->entity ?? null;

        // коллекция товаров этой категории
        $products = $entity->products;

        // добавляем новые
        $used->map(function ($item) use ($entity) {
            $find_record = $entity->entity_features->where('feature_id', $item['feature_id'])->first();
            if(!$find_record) {
                $entity->entity_features()->create(['feature_id'=>$item['feature_id']]);
            }
        });


        // удаляем не используемые
        $available->map(function ($item) use ($entity, $products){

            $record = $entity->entity_features->where('feature_id', $item['feature_id'])->first();

            if($record) :
                // удаляем у связанных с этой категорий товаров, характеристики
                $this->deleteRelatedProductFeatures($products, $item['feature_id']);
                // удаляем у категорий характеристики
                $record->delete();
            endif;

        });


        // устанавливаем хар-ку модификации
        if(isset($event->request['modify_feature']) && $event->request['modify_feature']) :
            $record = $entity->entity_features->where('feature_id', $event->request['modify_feature'])->first();

            if($record) :
                $record->update(['modify_feature'=>true]);
            endif;

        endif;
    }

    public function deleteRelatedProductFeatures($products, $feature_id)
    {

        if ( $products ) :
            foreach ($products as $product) :

                if( method_exists($product,'entity_features')) :
                    $product_features = $product->entity_features->where('feature_id', $feature_id);

                    foreach ($product_features as $feature){
                        $feature->delete();
                    }
                endif;

            endforeach;
        endif;
    }
}
