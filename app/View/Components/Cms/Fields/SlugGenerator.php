<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class SlugGenerator extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.fields.slug-generator');
    }
}
