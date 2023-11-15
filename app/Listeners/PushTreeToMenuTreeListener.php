<?php

namespace App\Listeners;

use App\Models\Menu;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PushTreeToMenuTreeListener
{

    private $locales;

    public function __construct()
    {
        $this->locales = app()->languages->all()->slug();
    }

    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        if ($event->root && $event->tree):
            $this->removeChildren($event->root);

            $traverse = function ($items, $root) use (&$traverse) {
                foreach ($items as $item) {

                    $node = $this->makeNode($item, $root);

                    $traverse($item->children, $node);
                }
            };

            $traverse($event->tree, $event->root);

        endif;
    }


    /**
     * Рекурсивно удаляет всех наследников.
     * withoutEvents - отключает событие удаления в menuObserver (там наследники удаляемого пункта перемещаются в корень)
     * а нам это не нужно - необходимо удалить все дерево категории
     *
     * @param [type] $root
     * @return void
     */
    private function removeChildren($root)
    {
        if (method_exists($root, 'forceDelete')) {

            Menu::withoutEvents(function () use ($root) {
                $root->children->each->forceDelete();
            });

        } else {

            Menu::withoutEvents(function () use ($root) {
                $root->children->each->delete();
            });

        }
    }

    private function makeNode($item, $root)
    {
        $data = [
            'page_id' => $item->page->id,
            'parent_id' => $root->id,
            'from'=>Menu::FRONTEND
        ];

        // подготавливаем данные для сохранения
        foreach ( $this->locales as $locale )
        {
            if($item->page->hasTranslation($locale)) {
                // присваиваем имя и статус такой же как у страницы
                $data[$locale]['name'] = $item->page->translate($locale)->name;
                $data[$locale]['publish'] = $item->page->translate($locale)->publish;
            }
        }

        $node = Menu::create($data);
        $root->appendNode($node);

        return $node;
    }
}
