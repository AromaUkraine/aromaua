<?php

namespace App\View\Components\Cms\Menu;

use Illuminate\View\Component;

class Menu extends MenuConstructor
{
    
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.menu.menu');
    }
}
