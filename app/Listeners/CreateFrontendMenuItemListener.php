<?php

namespace App\Listeners;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateFrontendMenuItemListener
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
        try {

            \DB::beginTransaction();

            // список всех языков сайта
            $locales = app()->languages->all()->slug();

            // находим родителя
            $root = Menu::where('from',  Menu::FRONTEND)->findOrFail($event->data['parent_id']);

            //находим страницу к которой привязан этот пункт меню
            $page = Page::findOrFail($event->data['page_id']);

            $data = $event->data;

            // подготавливаем данные для сохранения
            foreach ( $locales as $locale )
            {
                // если пустой массив с текущей локалью
                if(empty($data[$locale]) || !isset($data[$locale]))
                {
                    // но есть перевод текущей локали у страницы
                    if($page->hasTranslation($locale)) {

                        // присваиваем имя и статус такой же как у страницы
                        $data[$locale]['name'] = $page->translate($locale)->name;
                        $data[$locale]['publish'] = $page->translate($locale)->publish;
                    }

                }else{

                    //если нет имени у пункта меню, но есть у страницы
                    if(empty($data[$locale]['name']) && $page->translate($locale)->name)
                        $data[$locale]['name'] = $page->translate($locale)->name;

                    // если пункт в меню не опубликован, но опубликована страница - публикуем этот пункт
                    if(!$data[$locale]['publish'] && $page->translate($locale)->publish)
                        $data[$locale]['publish'] = $page->translate($locale)->publish;
                }
            }

            $menu = Menu::create($data);

            $root->appendNode($menu);

            \DB::commit();


        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
