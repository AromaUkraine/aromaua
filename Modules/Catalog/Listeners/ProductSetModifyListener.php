<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\ProductFeature;

class ProductSetModifyListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // устанавливает в поле modify_feature_value_id первое значение из product_features где
        // feature_id равно $product->category->modify_feature_id
//        if(isset($event->product)) :
//
//            $product = $event->product->with('product_features')->where('id',$event->product->id)->first();
//            $product_feature = $product->product_features->where('feature_id', $event->product->category->modify_feature_id)->first();
//
//            if($product_feature):
//                $event->product->update(['modify_feature_value_id'=>$product_feature->feature_value_id]);
//            endif;
//        endif;

    }
}
