<?php


namespace Modules\Catalog\View\Cms\Product;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\ProductCategory;

class FeatureItems extends Component
{
    /**
     * @var object
     */
    public $product_features = null;
    /**
     * @var object
     */
    public $category_features = null;

    public function __construct(object $model)
    {

        // получение хар-тик товара
        $this->product_features = $model->entity_features;

        $feature_ids = $model->category->entity_features->pluck('feature_id');

        $this->category_features = Feature::whereIn('id',$feature_ids)
            ->orderBy('order')
            ->with(['feature_kind'=>function($query){
                $query->with(['feature_values']);
            }])->get();
    }

    public function render()
    {
        return view('catalog::cms.components.product.feature-items');
    }

    /**
     * Возвращает числовое значение value
     * @param $feature_id
     * @return mixed
     */
    public function getNumberValue($feature_id)
    {
        $rec = $this->product_features->where('feature_id', $feature_id)->first();

        if($rec)
            return $rec->value;

        return null;
    }

    /**
     * Устанавливает selected выбраных значений в select-е
     * @param $feature_id
     * @param $feature_value_id
     * @return string
     */
    public function isSelected($feature_id, $feature_value_id)
    {
        return $this->product_features
            ->where('feature_id', $feature_id)
            ->where('feature_value_id', $feature_value_id)
            ->count() ? 'selected': '';
    }
}
