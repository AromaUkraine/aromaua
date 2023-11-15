<?php

namespace App\View\Components\Web\Footer;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class FooterMain extends WebComponents
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.footer.footer-main');
    }
}
