<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SeoCatalogCreateListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        $routes = config('catalog.routes.seo_catalog.web.index',[]);
        $data = array_merge($event->data, $routes);

        $event->entity->page()->create($data);
    }
}
