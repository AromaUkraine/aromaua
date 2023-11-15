<?php


namespace App\View\Components\Web\Menu;


use App\Models\Menu;
use App\View\Components\Web\WebComponents;

class MenuConstructor extends WebComponents
{

    public $activeClass;

    public $items = [];

    protected  $activeParentId = null;

    public function __construct($key)
    {

        $menu = Menu::frontend()
            ->whereActive(Menu::ACTIVE)
            ->with(['page' => function ($query) {
                $query->active()->published();
            }])
            ->defaultOrder()
            ->get()
            ->toTree();


        $this->items = $menu->where('type', $key)->first()->children;


        // запоминаем id корневой страницы если есть вложенность (для подсветки корневого элемента)
        $this->setActiveParentId();
    }


    public function render()
    {
        return null;
    }


    public function getActiveClass($item): string
    {
        if (!$item->page)
            return '';

        // главная страница
        if (request()->getPathInfo() == '/' && $item->page->slug == 'main') {
            return $this->activeClass;
        }


        // страницы без вложенностей
        if ($this->getCurrentPageSlug() == $item->page->slug) {
            return $this->activeClass;
        }

        // страницы с вложенными страницами
        if ($this->activeParentId == $item->id) {
            return $this->activeClass;
        }

        return '';

        // return \Str::contains(request()->getPathInfo(), $item->page->slug) ? $this->activeClass : '';
    }

    protected function setActiveParentId()
    {
        // получаем slug текущей страницы
        $slug = $this->getCurrentPageSlug();

        $traverse = function ($items) use (&$traverse, $slug, &$activeParentId) {
            foreach ($items as $item) {


                if ($item->page && $item->page->slug == $slug) { //&&  $item->page->slug == $slug

                    if ($item->parent) {
                        $this->activeParentId = $item->parent->parent_id;
                    } else {
                        $this->activeParentId = $item->parent_id;
                    }
                }

                if ($item->children->count())
                    $traverse($item->children);
            }
        };

        $traverse($this->items);
    }
}