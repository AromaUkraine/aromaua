<?php


namespace Modules\Catalog\View\Cms\Filter;


use Modules\Catalog\View\Cms\Feature\FeatureList;

class FilterFeature extends FeatureList
{

    public function render()
    {
        return view('catalog::cms.components.filter.filter-feature');
    }

}
