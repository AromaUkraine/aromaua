<?php


namespace Modules\Catalog\Http\Controllers\Cms;


use App\Services\ModelService;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Catalog\DataTables\ProductCategoryPriceDataTable;

class ProductCategoryPriceController extends Controller
{
    public function index($table, $id, ProductCategoryPriceDataTable $dataTable)
    {
        // находим модель по имени таблицы в базе данных
        $entity = app(ModelService::class)->findEntityByTableId($table, $id);
        return $dataTable->render('catalog::cms.product_category_price.index', compact('table', 'id', 'entity'));
    }

}
