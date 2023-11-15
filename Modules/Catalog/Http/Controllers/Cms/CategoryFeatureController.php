<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Services\ModelService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Events\CategoryFeatureCreateFeatureEvent;
use Modules\Catalog\Events\CategoryFeatureUpdateFeatureEvent;

class CategoryFeatureController extends Controller
{
    public function index($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return view('catalog::cms.category_feature.index', compact('table','id', 'entity'));
    }

    public function store(Request $request, $table, $id)
    {

        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        $used = null;

        if (!$entity->entity_features->count()) :
            event( new CategoryFeatureCreateFeatureEvent($request, $entity));
            toastr()->success(__('toastr.created.message'));
        else :

            event( new CategoryFeatureUpdateFeatureEvent($request, $entity));
            toastr()->success(__('toastr.updated.message'));
        endif;

        return redirect(route('module.category_feature.index',[$table, $id]));
    }
}
