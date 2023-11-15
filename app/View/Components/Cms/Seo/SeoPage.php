<?php

namespace App\View\Components\Cms\Seo;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class SeoPage extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
       return view('components.cms.seo.seo-page');
    }
}
