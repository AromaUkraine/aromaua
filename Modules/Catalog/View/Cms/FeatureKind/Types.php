<?php


namespace Modules\Catalog\View\Cms\FeatureKind;


use Illuminate\View\Component;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\FeatureKind;
use Modules\Catalog\Entities\SeoCatalog;

class Types extends Component
{

    public function __construct(?object $model = null, ?string $name='')
    {

        $types = Feature::with('feature_kind')->get();

        $test = SeoCatalog::getPossibleEnumValues('type');
        dump($test);
    }



    public function render()
    {

    }
}
