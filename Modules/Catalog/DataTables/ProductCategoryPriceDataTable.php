<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Synchronize\Entities\ProductProductCategoryPrice;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryPriceDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'id',
            'name' => 'id',
            'title' => '#',
        ],
        [
            'data' => 'category_name',
            'title' => 'категория'
        ],
        [
            'data' => 'series',
            'name' => 'series',
            'title' => 'серия',
            // 'orderable' => false
        ],
        [
            'data' => 'column_number',
            'name' => 'column_number',
            'title' => 'номер колонки',
            // 'orderable' => false
        ],
        [
            'data' => 'column_name',
            'name' => 'column_name',
            'title' => 'название колонки',
            // 'orderable' => false
        ],
        [
            'data' => 'price',
            'name' => 'price',
            'title' => 'цена',
            // 'orderable' => false
        ],
        [
            'data' => 'currency',
            'name' => 'currency',
            'title' => 'валюта',
            // 'orderable' => false
        ],


    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $this->query = ProductProductCategoryPrice::select(
            'product_product_category_prices.id as id', 'product_category_id',
            'series', 'column_number', 'column_name', 'price', 'currency',
            'product_categories.code_1c as category_1c', 'page_translations.name as category_name'
        )->join('product_product_category_price_translations', function ($join){
            $join->on('product_product_category_prices.id','=','product_product_category_price_translations.product_product_category_price_id')
                ->where('locale', app()->getLocale());
        })->join('product_categories', function ($join){
            $join->on('product_product_category_prices.product_category_id','=','product_categories.id')
                ->join('pages', function ($join){
                    $join->on('product_categories.id','=','pageable_id')
                        ->where('pageable_type', 'Modules\Catalog\Entities\ProductCategory')
                        ->join('page_translations', function ($join){
                            $join->on('pages.id','=','page_translations.page_id')
                                ->where('locale', app()->getLocale());
                        });
                });
        })
        ->where('product_id', request()->id);
//        ->orderBy('product_product_category_prices.id');

        $this->query->newQuery();
    }

    public function dataTable()
    {
        $datatable = datatables()->eloquent($this->query);

        return $datatable
            ->filter(function ($query) {

            })
            ->addColumn('column_name', function ($data) {
                return $data->column_name;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['id','product_category_id','series','column_number','column_name','price','currency','action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = '';

        return $buttons;
    }
}
