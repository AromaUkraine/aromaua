<?php

namespace App\View\Components\Web\Menu;

use App\Models\Menu;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class MenuFooter extends MenuConstructor
{
    public $activeClass = 'topline-menu__link--active';

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.menu.menu-footer');
    }

}
