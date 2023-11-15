<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\PriceType;
use Nwidart\Modules\Facades\Module;


class PriceTypeList extends Component
{

    public $types;
    /**
     * @var mixed|null
     */
    private $model;

    public function __construct($model = null)
    {

        $this->types = PriceType::all();
        $this->model = $model;
    }

    public function render()
    {
        return view('catalog::cms.components.product.price-type-list');
    }


    public function setSelected($type)
    {
        if(!$this->model)
            return;

        return ($this->model->price->type->id == $type->id) ? 'selected' : '' ;
    }
}
