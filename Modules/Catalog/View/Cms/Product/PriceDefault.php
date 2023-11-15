<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\PriceType;

class PriceDefault  extends Component
{
    public $name = 'price_default';

    public $value;
    /**
     * @var |null
     */
    public $currency;
    /**
     * @var |null
     */
    public $label;

    public function __construct(?object $model = null)
    {

        $type = PriceType::default()->first();

        $this->label = $type->name.' '.$type->currency->short_name;

        if($model) :
            $this->value = $model->defaultPrice->value ?? null;
        endif;
    }

    public function render()
    {
        return view('catalog::cms.components.product.price-default');
    }
}
