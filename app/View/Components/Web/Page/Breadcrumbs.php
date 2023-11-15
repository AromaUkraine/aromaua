<?php

namespace App\View\Components\Web\Page;

use App\Models\Page;
use App\View\Components\Web\WebComponents;
use Illuminate\Http\Request;
use Illuminate\View\Component;

class Breadcrumbs extends WebComponents
{

    public $items;

    /**
     * Create a new component instance.
     *
     * @param Page $page
     * @param object|null $root
     * @param object|null $ancestors
     * @param object|null $category
     */
    public function __construct(Page $page, ?object $root = null, ?object $ancestors = null, ?object $category = null)
    {

        $this->items = collect();
        $main = $this->getMainPage();

        /*** Главная страница ***/
        if($main) {
            $this->items->push($main);
        }

        /*** родительская страница ***/
        if($root) {
            $this->items->push($root);
        }

        /*** предки текущей ***/
        if($ancestors) {
            $ancestors->map(function ($res) {
                $this->items->push($res->page);
            });
        }

        /*** Категория ***/
        if($category) {
            $this->items->push($category->page);
        }

        /*** текущая ***/
        $this->items->push($page);

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.page.breadcrumbs');
    }

    public function getName($item)
    {
        return $item->breadcrumbs ?? $item->name;
    }
}
