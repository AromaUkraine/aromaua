<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;

class ModifyFeatureValueList extends Component
{

    public $feature_values;

    public $modify_value;

    public $name;

    public function __construct($model,  $name)
    {

        $this->name = $name;
        // все значения у модификации категории
        if($model->category && $model->category->modify_feature):

            $this->feature_values = Feature::where('id',$model->category->modify_feature)
                ->with(['feature_kind'=>function($query){
                    $query->with(['feature_values']);
                }])->first()->feature_kind->feature_values;

            // если товару добавлены хар-ки
            if($model->entity_features):

                $entity_features = $model->entity_features->where('feature_id', $model->category->modify_feature);

                $this->modify_value = $model->modify_value;

                $this->feature_values = $this->feature_values->filter(function ($feature_value) use($entity_features){
                    if($entity_features->contains('feature_value_id', $feature_value->id)){
                        return $feature_value;
                    }
                });

            endif;

        endif;
    }


    public function render()
    {
        return view('catalog::cms.components.product.modify-feature-value-list');
    }


    public function setSelected($feature_value_id)
    {

        $selected = '';
        if($this->modify_value == $feature_value_id):
            $selected = 'selected';
        endif;

        return $selected;
    }
}
