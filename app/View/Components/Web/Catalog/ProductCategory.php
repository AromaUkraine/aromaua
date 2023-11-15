<?php

namespace App\View\Components\Web\Catalog;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class ProductCategory extends WebComponents
{
    public $category;

    /**
     * Create a new component instance.
     *
     * @param $category
     */
    public function __construct($category)
    {
        //
        $this->category = $category;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.catalog.product-category');
    }
}
