<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SeoCatalogModifyListener
{


    public function handle($event)
    {

        if($event->entity->is_brand ) :
            $event->entity->update(['country_id' => $event->data['country_id'] ?? null]);
        endif;

        if(isset($event->data['product_category_id'])) :
            $event->entity->update(['product_category_id' => $event->data['product_category_id'] ]);
        endif;

        if(isset($event->data['feature'])) :
            $event->data = $event->data['feature'];
        else:
            $event->data = [];
        endif;
    }
}
