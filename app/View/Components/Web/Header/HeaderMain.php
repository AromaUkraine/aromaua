<?php

namespace App\View\Components\Web\Header;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class HeaderMain extends WebComponents
{
    public $page;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?object $page)
    {
        $this->page = $page;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.header.header-main');
    }
}
