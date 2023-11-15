<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ToggleFrontendMenuItems
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        // Находим все пункты меню принадлежащие этой странице
        $menu = Menu::where('page_id', $event->page->id)->get();

        // выключаем пункт меню если страница отключена соответственно
        $menu->map(function ($item) use ($event) {
            if(!$event->page->active){
                $item->update(['active'=>false]);
            }
        });
    }
}
