<?php

namespace Modules\Catalog\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SeoCatalogFeatureListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if($event->data) :
            foreach ($event->data as $rec):
                $explode_data = explode(',', $rec);
                $key = array_shift($explode_data);
                $value = end($explode_data);

                if(!isset($event->feature_values[$key])) :
                    $event->feature_values[$key] = array($value);
                else:
                    $event->feature_values[$key] = array_merge( $event->feature_values[$key], array($value));
                endif;

            endforeach;
        endif;

        $event->product = $event->entity;
    }
}
