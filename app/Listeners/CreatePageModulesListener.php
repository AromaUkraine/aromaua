<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreatePageModulesListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->page->components()->delete();

        if($event->pageable->components) {

            foreach ($event->pageable->components as $data){

                $event->page->components()->create($data);
            }
        }
    }
}
