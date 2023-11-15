<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\FeatureValue;

class FeatureModify extends Component
{

    public  $feature_values;

    public $model;


    public $default;

    public function __construct($model)
    {
        $this->model = $model;

        $feature_value_ids = $model->product_features->where('feature_id', $model->category->modify_feature->id)->pluck('feature_value_id');
        $this->feature_values = FeatureValue::whereIn('id',$feature_value_ids)->get();
        $this->default = $this->feature_values->first();
    }


    public function render()
    {
        return view('catalog::cms.components.product.feature-modify');
    }


    public function setSelected($feature_value_id)
    {
        $selected = null;
        if(!$this->model->modify_feature_value_id) :
            if( $this->default &&  $this->default->id == $feature_value_id):
                $selected = 'selected';
            endif;
        else:
            if($this->model->modify_feature_value_id == $feature_value_id):
                $selected = 'selected';
            endif;
        endif;

        return $selected;
    }
}
