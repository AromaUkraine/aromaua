<?php


namespace Modules\Catalog\View\Cms\SeoCatalog;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;

class Repeater extends Component
{

    public $entity_features;

    public $all_features;

    public $id;

    public $options;

    public function __construct($model)
    {
        $this->id = $model->id;

        $this->getAllFeatures($model);

        $this->entity_features = $model->entity_features->groupBy('feature_id');

    }


    public function render()
    {
        return view('catalog::cms.components.seo_catalog.repeater');
    }

    public function setFeatureSelected($feature, $feature_id)
    {
        if($feature->contains('feature_id', $feature_id)):
            return 'selected';
        endif;

        return null;
    }


    public function setFeatureValueSelected($feature, $value)
    {
        if($feature->contains('feature_value_id', $value['id'])):
            return 'selected';
        endif;

        return null;
    }


    public function setOptions($feature)
    {
        // текущий id хар-ки
        $feature_id = $feature->first()->feature_id;

        $this->options = $this->all_features->map(function ($item) use($feature_id) {
            if($item->id == $feature_id) {
                return $item->feature_kind->feature_values->map(function ($value) use($feature_id){
                    return [
                        'id'=>$value->id,
                        'value' => $feature_id.','.$value->id,
                        'name' => $value->name
                    ];
                });
            }
        })->filter(function ($item){
            return !is_null($item);
        })->first();

    }

    public function getOptions(){
        return $this->options;
    }


    private function getAllFeatures($model)
    {
        // берем хар-ки привязаной категории
        if($model->product_category_id) :

            $this->all_features = ProductCategory::with(['entity_features'=>function($query){
                $query->with(['feature'=>function($query){
                    $query->with(['feature_kind'=>function($query){
                        $query->with('feature_values');
                    }]);
                }]);
            }])->where('id', $model->product_category_id)->first()->entity_features->map(function ($item){
                return $item->feature;
            });

        // берем все хар-ки
        else:
            $this->all_features = Feature::with(['feature_kind' => function($query){
                $query->with('feature_values');
            }])->get();
        endif;
    }
}
