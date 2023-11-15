<?php

namespace App\Listeners;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateFrontendMenuItemListener
{

    /***
     * $data - обязательные параметры !!!
     * parent_id - id родительского пункта меню
     * page_id  - id страницы к которой этот пункт привязан
     * from - frontend
     */


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        if($event->status === 'add') :
            // список всех языков сайта
            $locales = app()->languages->all()->slug();

            $data = [
                'page_id' => $event->page->id,
                'parent_id' => $event->menu->id,
                'from'=>Menu::FRONTEND
            ];

            // подготавливаем данные для сохранения
            foreach ( $locales as $locale )
            {
                if($event->page->hasTranslation($locale)) {
                    // присваиваем имя и статус такой же как у страницы
                    $data[$locale]['name'] = $event->page->translate($locale)->name;
                    $data[$locale]['publish'] = $event->page->translate($locale)->publish;
                }
            }
            $node = Menu::create($data);
            $event->menu->appendNode($node);

        else:

             Menu::frontend()
                ->where('parent_id',$event->menu->id)
                ->where('page_id',$event->page->id)
                ->forceDelete();
        endif;
    }
}
