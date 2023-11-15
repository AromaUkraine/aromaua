<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ToggleActivePageListener
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // обновляем active страницы
        $event->page->update(['active'=>!$event->page->active]);
    }
}
