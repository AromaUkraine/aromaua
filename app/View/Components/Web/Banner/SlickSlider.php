<?php

namespace App\View\Components\Web\Banner;

use Illuminate\View\Component;

class SlickSlider extends BannerConstructor
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        if($this->items){
            return view('components.web.banner.slick-slider');
        }
    }
}
