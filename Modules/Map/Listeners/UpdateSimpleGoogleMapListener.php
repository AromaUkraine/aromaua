<?php

namespace Modules\Map\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Shop\Entities\Shop;

class UpdateSimpleGoogleMapListener
{

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        if(isset($event->data['simple']) && $event->data['simple']):
            $shop = Shop::first();
            $shop->update($event->data);
        endif;
    }
}
