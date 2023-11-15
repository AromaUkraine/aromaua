<?php

namespace App\View\Components\Cms\Repeat;

use App\View\Components\Cms\BaseCmsComponent;


class RepeatItems extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.repeat.repeat-items');
    }
}
