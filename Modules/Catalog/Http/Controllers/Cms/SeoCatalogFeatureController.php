<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Services\ModelService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\Events\SeoCatalogFeatureEvent;
use Modules\Catalog\Http\Requests\SeoCatalogFeatureRequest;

class SeoCatalogFeatureController extends Controller
{



    public function index($table, $id)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        return view('catalog::cms.seo_catalog_feature.index', compact('table', 'id', 'entity'));
    }

    public function store(SeoCatalogFeatureRequest $request , $table, $id)
    {

        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        event(new SeoCatalogFeatureEvent($request->all(), $entity));

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('module.seo_catalog_feature.index',[$table, $id]));
    }
}
