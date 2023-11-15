<?php

namespace App\View\Components\Web\Menu;

use Illuminate\View\Component;

class MenuTop extends MenuConstructor
{
    public $activeClass = 'topline-menu__link--active';

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.menu.menu-top');
    }

}
