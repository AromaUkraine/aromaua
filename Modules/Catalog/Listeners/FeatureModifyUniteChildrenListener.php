<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\Product;

class FeatureModifyUniteChildrenListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if(isset($event->data['used'])) :
            $used = collect(json_decode($event->data['used'], true));

            // находим "наследников" - которые будут привязанны по модификации
            if($used->count()) :
                $children_ids = $used->pluck('id');

                $event->childes = Product::whereIn('id', $children_ids)->get();
            else:
                $event->childes = null;
            endif;

        endif;
    }
}
