<?php


namespace Modules\Catalog\View\Cms\Filter;


use Modules\Catalog\View\Cms\FeatureValues\FeatureValuesList;

class FilterFeatureValues extends FeatureValuesList
{

    public function render()
    {
//        if( request()->has('feature_id') ) {
//            $this->feature_values = $this->feature_values
//        }

        return view('catalog::cms.components.filter.filter-feature-values');
    }
}
