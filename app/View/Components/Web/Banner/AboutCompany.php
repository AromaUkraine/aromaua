<?php

namespace App\View\Components\Web\Banner;

use Illuminate\View\Component;

class AboutCompany extends BannerConstructor
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

       if($item = $this->items->first()){
            return view('components.web.banner.about-company', compact('item'));
        }
    }
}
