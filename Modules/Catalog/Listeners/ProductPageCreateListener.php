<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class ProductPageCreateListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(method_exists(Product::class,'page')):
            $routes = config('catalog.routes.product.web.index',[]);
            $event->data = array_merge($event->data, $routes);
            $event->product->page()->create($event->data);
        endif;
    }
}
