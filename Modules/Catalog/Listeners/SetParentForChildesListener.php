<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SetParentForChildesListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {

        if(isset($event->product) && $event->product) :
            $product = $event->product;

            if(isset($event->childes) && $event->childes->count()):
                $childes = $event->childes;

                $childes->map(function ($child) use ($product) {
                    $data = ['parent_product_id'=>$product->id];
                    $child->update($data);
                });
            endif;

        endif;

    }
}
