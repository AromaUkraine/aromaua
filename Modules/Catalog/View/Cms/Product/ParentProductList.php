<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Product;

class ParentProductList extends Component
{

    public $parent_products;

    public $name;

    public function __construct($model, $name)
    {
        $this->name = $name;

        $this->parent_products = Product::where('product_category_id',$model->product_category_id)
            ->get()->groupBy('parent_product_id')->map(function ($product_group, $key) use($model){
                return $product_group->where('parent_product_id', $key)->where('id', '!=', $model->id)->first();
            })->filter(function ($item){
                return !is_null($item);
            });

    }

    public function render()
    {
        return view('catalog::cms.components.product.parent-product-list');
    }

    public function setSelected($parent_product_id)
    {
        if(old('parent_product_id') && old('parent_product_id') == $parent_product_id):
            return 'selected';
        endif;

        return null;
    }
}
