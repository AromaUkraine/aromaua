<?php

namespace App\View\Components\Web\Menu;

use App\Models\Menu;
use App\Models\Page;
use Illuminate\View\Component;
use Modules\Catalog\Entities\ProductCategory;

class MenuMain extends MenuConstructor
{

    public $activeClass = "menu__item--active";

    public $page;

    public function __construct($key, ?object $page)
    {
        $this->page = $page;
        parent::__construct($key);
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        return view('components.web.menu.menu-main');
    }

}
