<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CatalogProductUpdateListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->product->update([
            'product_category_id'=>$event->data['product_category_id'],
            'vendor_code'=>$event->data['vendor_code'] ?? null,
            'product_code'=>$event->data['product_code'] ?? null,
        ]);

        $event->product->page->update($event->data);
    }
}
