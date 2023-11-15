<?php

namespace App\View\Components\Web\Product;

use Illuminate\View\Component;
use Modules\Catalog\Entities\Product;
use App\View\Components\Web\WebComponents;

class ProductGallery extends WebComponents
{
    public $product = null;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(?object $product)
    {
        $this->product = $product;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.product.product-gallery');
    }
}
