<?php

namespace App\View\Components\Cms\Buttons;

use Illuminate\View\Component;

class Action extends Button
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.buttons.action');
    }
}
