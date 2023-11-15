<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Services\ModelService;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Events\ProductFeatureCreateFeatureValueEvent;
use Modules\Catalog\Events\ProductFeatureCreateValueEvent;
use Modules\Catalog\Events\ProductFeatureUpdateFeatureValueEvent;
use Modules\Catalog\Events\ProductFeatureUpdateValueEvent;

class ProductFeatureController extends Controller
{
    public function index($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return view('catalog::cms.product_feature.index', compact('table', 'id', 'entity'));
    }


    public function store(Request $request, $table, $id)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        if(method_exists($entity, 'entity_features')) :
            if (!$entity->entity_features->count()) :

                event( new ProductFeatureCreateValueEvent($request, $entity) );
                event( new ProductFeatureCreateFeatureValueEvent($request, $entity));

                toastr()->success(__('toastr.created.message'));
            else :

                event( new ProductFeatureUpdateValueEvent($request, $entity) );
                event( new ProductFeatureUpdateFeatureValueEvent($request, $entity));

                toastr()->success(__('toastr.updated.message'));
            endif;
        endif;

        return redirect(route('module.product_feature.index', [$table, $id]));
    }

}
