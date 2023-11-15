<?php


namespace Modules\Catalog\View\Cms\Feature;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;

class FeatureList extends Component
{

    public $features;

    public function __construct()
    {
        $this->features = Feature::get();
    }

    public function render()
    {
        // TODO: Implement render() method.
    }
}
