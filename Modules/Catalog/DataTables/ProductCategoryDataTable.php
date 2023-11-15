<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\ProductCategory;
use Yajra\DataTables\Services\DataTable;

class ProductCategoryDataTable extends DataTable
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

        ],
        [
            'data' => 'code_1c',
            'title' => 'cms.card_code',
        ],
//        [
//            'data' => 'parent_page_name',
//            'name' => 'parent_page_name',
//            'title' => 'cms.category_belongs_to_page'
//        ],
        [
            'data' => 'product_category_name',
            'name' => 'product_category_name',
            'title' => 'cms.category_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'products_count',
            'name' => 'products_count',
            'title' => 'cms.category_products_count',
            'orderable' => false,
            'sortable' => false,
        ],
    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

//        if ($this->totalCount > 1) {
//            $this->attributes = [
//                'data-model' => ProductCategory::class,
//                'class' => 'table  sortable',
//                'data-url' => route('sortable')
//            ];
//        }
    }

    public function query()
    {

        $this->query = ProductCategory::select(
            'product_categories.id as id',
            'product_categories.code_1c as code_1c',
            'product_categories.order',
            'pages.id as page_id',
            'page_translations.id as page_translations_id',
            'pt.name as product_category_name',
            'page_translations.name as parent_page_name'
        )
            ->withCount('products')
            ->leftJoin('pages as category_page', function ($join) {
                $join->on('category_page.pageable_id', '=', 'product_categories.id')
                    ->where('category_page.pageable_type', ProductCategory::class)
                    ->join('page_translations as pt', function ($join) {
                        $join->on('category_page.id', '=', 'pt.page_id')
                            ->where('pt.locale', app()->getLocale());
                    });
            })
            ->leftJoin('pages', function ($join) {
                $join->on('pages.id', '=', 'product_categories.parent_page_id')
                    ->join('page_translations', function ($join) {
                        $join->on('pages.id', '=', 'page_translations.page_id')
                            ->where('page_translations.locale', app()->getLocale());
                    });
            });
        if (request('trash')) {
            $this->query->with(['page' => function ($query) {
                $query->onlyTrashed();
            }])->onlyTrashed();
        }

        $this->query->newQuery();
    }

    public function dataTable()
    {
        $datatable = datatables()->eloquent($this->query);

        /** добавлено для сортировки **/
        if ($this->totalCount > 1) {

            $datatable
                ->setRowClass('row-sort')
                ->setRowAttr(['data-id' => function ($data) {
                    return $data->id;
                },
                ]);
        }

        return $datatable
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {

                    $query->whereHas('page', function ($q) {
                        $q->join('page_translations', function ($join) {
                            $join->on('pages.id', '=', 'page_translations.page_id')
                                ->where('name', 'like', "%" . request('search')['value'] . "%");
                        });
                    })
                        ->orWhere('code_1c', 'like', "%" . request('search')['value'] . "%");
                }
            })
            ->addColumn('product_category_name', function ($data) {
                if (isset($data->page)):
                    return $this->link(route('catalog.product_category.edit', $data->id), $data->page->name);
                endif;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'product_category_name', 'action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('catalog.product_category.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('catalog.product_category.restore', ['category' => $data->id]));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('catalog.product_category.edit')) {
                $buttons .= DataTableButton::make()->edit(route('catalog.product_category.edit', $data->id));
            }
            if (\Auth::user()->can('catalog.product_category.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->page->active, route('catalog.product_category.active', $data->id));
            }
            if (\Auth::user()->can('catalog.product_category.destroy')) {
                $buttons .= DataTableButton::make()->delete(route('catalog.product_category.destroy', $data->id));
            }

        }

        return $buttons;
    }
}
