<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CategoryProductPageCreateListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        if(isset($event->data)) :
            $routes = config('catalog.routes.product_category.web.view',[]);
            $data = array_merge($event->data, $routes);
            $event->category->page()->create($data);
        endif;
    }
}
