<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Nwidart\Modules\Facades\Module;

class CreateEntityColorSchemeListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if(isset($event->request['color_scheme_id'])) :
            // если есть модуль ColorScheme и у сущности есть трейт связывающий его с EntitiesColors
            if(Module::find('ColorScheme') && method_exists($event->entity,'colorable')):
                $event->entity->colorable()->create([ 'color_scheme_id'=>$event->request['color_scheme_id'] ]);
            endif;

        endif;
    }
}
