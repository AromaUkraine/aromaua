<?php


namespace Modules\Catalog\View\Cms\FeatureValues;


use Illuminate\View\Component;
use Modules\Catalog\Entities\FeatureValue;

class FeatureValuesList extends Component
{

    public $feature_values;

    public function __construct()
    {
        $this->feature_values = FeatureValue::get();
    }

    public function render()
    {

    }
}
