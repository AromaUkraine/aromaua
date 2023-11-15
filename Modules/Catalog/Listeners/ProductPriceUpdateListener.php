<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class ProductPriceUpdateListener
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

            if(isset($event->data['price'])):
                $event->product->price->update($event->data['price']);
            endif;

        endif;
    }
}
