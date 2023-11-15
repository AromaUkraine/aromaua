<?php

namespace App\View\Components\Web\Header;


use App\Models\Menu;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class HeaderTop extends WebComponents
{
    public $page;

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
        return view('components.web.header.header-top');
    }
}