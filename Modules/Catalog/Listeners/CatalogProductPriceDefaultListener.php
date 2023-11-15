<?php

namespace Modules\Catalog\Listeners;


use Modules\Catalog\Entities\PriceType;

class CatalogProductPriceDefaultListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {


        if(method_exists(PriceType::class,'default')){

            if(isset($event->data['price_default'])) {

                $product = $event->product;

                $price = $event->data['price_default'] ?? 0;

                $default_price_type = PriceType::default()->first();


                if(!$product->defaultPrice) :
                    $product->defaultPrice()->create(['value'=>$price,'price_type_id'=>$default_price_type->id]);
                else:
                    $product->defaultPrice->update(['value'=>$price]);
                endif;
            }


        }

    }
}
