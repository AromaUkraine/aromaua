<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Services\ModelService;
use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Events\ChangeEntityFeatureEvent;
use Modules\Catalog\DataTables\SeoCatalogProductDataTable;


class SeoCatalogProductController extends Controller
{

    public function index($table, $id, SeoCatalogProductDataTable $dataTable)
    {
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        if(!$entity->entity_features->count()):
            return view('catalog::cms.seo_catalog_product.warning', compact('table', 'id', 'entity'));
        endif;

        return $dataTable->render('catalog::cms.seo_catalog_product.index', compact('table', 'id', 'entity'));
    }

    public function change($table, $id, Product $product, $status)
    {
        //entity - сео-страница
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);

        // в фильтре содержатся хар-тики сео-страницы
        $filter = (new Product())->makeFilter(request(), $entity->entity_features);

        try {
            \DB::beginTransaction();

            event(new ChangeEntityFeatureEvent($product, $filter['feature'], $status));


            \DB::commit();
        } catch (\Exception $e) {

            \DB::rollback();
            dd($e->getMessage());
        }

        return response()->json(['message' => __('toastr.updated.message')]);
    }

}
