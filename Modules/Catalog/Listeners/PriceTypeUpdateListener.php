<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductPrice;

class PriceTypeUpdateListener
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

            if(method_exists(ProductPrice::class,'type')) :

                if(isset($event->data['price_type'])):

                    $event->product->price->type->update($event->data['price_type']);
                endif;

            endif;

        endif;
    }
}
