<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\Product;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes = [
        'serverSide' => false
    ];

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
            'data' => 'name',
            'title' => 'cms.product_name',
            'orderable' => false
        ],
        [
            'data' => 'code_1c',
            'name' => 'code_1c',
            'title' => 'cms.card_code',
            // 'orderable' => false
        ],
        [
            'data' => 'product_code',
            'name' => 'product_code',
            'title' => 'cms.product_code',
            // 'orderable' => false
        ],
        [
            'data' => 'code',
            'name' => 'code',
            'title' => 'cms.code',
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

        $this->query = Product::with([
            'page',
            'category'
        ]);

        if (request('trash')) {
            $this->query->with([
                'page' => function ($query) {
                    $query->onlyTrashed();
                },
                'category' => function ($query) {
                    $query->onlyTrashed();
                }
            ])->onlyTrashed();
        }

        $this->query->newQuery();
    }

    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->filter(function ($query) {

                if (request()->has('trash')) {
                    $query->onlyTrashed();
                }

                if (request()->has('search') && request('search')['value']) {
                    $query->whereHas('page', function ($q) {
                        $q->join('page_translations', function ($join) {
                            $join->on('pages.id', '=', 'page_translations.page_id')
                                ->where('name', 'like',  "%" . request('search')['value'] . "%");
                        });
                    });
                }

                if (request()->order_price) {
                    $query->orderBy('value', request()->order_price);
                }

                if (request()->product_code) {

                    //$query->orderBy('value');
                    $query->where('product_code', 'like', "%" . request()->product_code . "%");
                }
                if (request()->code_1c) {
                    $query->where('code_1c', 'like', "%" . request()->code_1c . "%");
                }
                if (request()->series) {
                    //$data->price->type->key;
                    $query->whereHas('price', function ($q) {
                        $q->whereHas('type', function ($q) {
                            $q->where('key', 'like', "%" . request()->series . "%");
                        });
                    });
                }
                if (request()->product_category) :
                    $query->where('product_category_id', request()->product_category);
                endif;

                if (request()->has('code')) :

                    $code = request()->code;
                    $query
                        ->where('vendor_code', 'like',  "%" . $code . "%")
                        ->orWhere('product_code',  'like',  "%" . $code . "%");
                endif;
            })
            ->addColumn('name', function ($data) {
                if (isset($data->page)) :
                    return  $this->link(route('catalog.product.edit', $data->id), $data->page->name);
                else :
                    return  $this->link(route('catalog.product.edit', $data->id), $data->parent->page->name);
                endif;
            })
            ->addColumn('product_code', function($data){
                return str_replace('|',"<br>", $data->product_code);
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['photo', 'price', 'product_code', 'name', 'action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('catalog.product.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('catalog.product.restore', $data->id)); //btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }
        } else {

            if (\Auth::user()->can('catalog.product.edit')) {
                $buttons .= DataTableButton::make()->edit(route('catalog.product.edit', $data->id));
            }
            if (\Auth::user()->can('catalog.product.active')) {
                if (isset($data->page)) :
                    $buttons .= DataTableButton::make()->toggleActive($data->page->active, route('catalog.product.active', $data->id));
                else :
                    //91806
                    $buttons .= DataTableButton::make(['class' => 'success', 'icon' => 'bx bx-show-alt'])->disabled()->edit();
                endif;
            }
            if (\Auth::user()->can('catalog.product.destroy')) {
                //                $buttons .= '<form action="'.route('catalog.product.destroy', $data->id).'" method="post">
                //                    '.csrf_field().method_field('DELETE').'
                //                    <button type="submit">delete</button>
                //                </form>';
                $buttons .= DataTableButton::make()->delete(route('catalog.product.destroy', $data->id));
            }
        }

        return $buttons;
    }
}
