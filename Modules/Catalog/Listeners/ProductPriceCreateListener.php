<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\PriceType;
use Modules\Catalog\Entities\Product;

class ProductPriceCreateListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(method_exists(Product::class,'price')) :

            if(isset($event->data['price']) && isset($event->data['price_type']['key'])):

                $price_type = PriceType::where('key', $event->data['price_type']['key'])->first();

                if($price_type) :

                    $event->data['price']['price_type_id'] = $price_type->id;
                    $event->product->price()->create($event->data['price']);

                endif;

            endif;

        endif;
    }
}
