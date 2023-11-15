<?php


namespace Modules\Catalog\View\Cms\SeoCatalog;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\FeatureValue;

class Brand extends Component
{


    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public $brands;
    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public $countries;
    /**
     * @var object
     */
    private $model;

    private $feature_value_id = null;


    public function __construct(?object $model = null)
    {
        $this->model = $model;

        if($this->model && $this->model->entity_features->count()):
            $this->feature_value_id = $this->model->entity_features->first()->feature_value_id;
        endif;

        $this->brands = $this->getAllValuesWhereFeatureKInd(FeatureKind::IS_BRAND);
        $this->countries = $this->getAllValuesWhereFeatureKInd(FeatureKind::IS_COUNTRY);
    }

    public function render()
    {
        return view('catalog::cms.components.seo_catalog.brand');
    }

    private function getAllValuesWhereFeatureKInd($key)
    {
        return Feature::withAndWhereHas('feature_kind' , function ($query) use ($key){
            $query->where('key', $key);
            $query->with(['feature_values']);
        })->first();
    }

    public function getFeatureId($item)
    {
        return $item->id;
    }

    public function setSelectedBrand($brand_id)
    {
        return ($this->feature_value_id == $brand_id) ? 'selected' : '';
    }

    public function setSelectedCountry($country_id)
    {
        if($this->model):
            return ($this->model->country_id == $country_id) ? 'selected' : '';
        endif;
    }

}
