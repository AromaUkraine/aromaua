<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use Modules\Catalog\Entities\Product;
use Yajra\DataTables\Services\DataTable;

class FeatureModifyDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    private $query;

    public $columns = [
        [
            'data' => 'id',
            'name' => 'id',
            'title' => '#',
        ],
        [
            'data' => 'photo',
            'title' => 'cms.product_photo',
            'orderable' => false
        ],
        [
            'data' => 'name',
            'title' => 'cms.product_name',
            'orderable' => false
        ],
        [
            'data' => 'parent',
            'title' => 'cms.parent_product',
            'orderable' => false
        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $product = Product::find(request()->id);

        $this->query = Product::with(['gallery', 'page']);

        // если товар наследует модификацию
        if($product->parent) :
            $this->query->where('parent_product_id', $product->parent->id);
        // если товар является основным в модификации
        elseif($product->children->count()) :
            $this->query->where('parent_product_id', request()->id);
        // если у товара еще нет модификации
        else :
            $this->query->where('parent_product_id', request()->id)
                ->where('id','!=', request()->id);
        endif;

        $this->query->newQuery();
    }


    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->addColumn('photo', function ($data){
                if ($data->gallery->count()) :
                    return '<img src="'.$data->gallery[0]->thumbs.'" style="width:80px;" />';
                endif;
            })
            ->addColumn('name', function ($data){
                if(isset($data->page)):
                    return  $this->link(route('catalog.product.edit', $data->id), $data->page->name);
                endif;
            })
            ->addColumn('parent', function ($data){
                return $this->radioButton( $data->id, $data->parent_product_id, route('module.feature_modify.change_parent'));
            })
            ->addColumn('action', function ($data) {
                return null;
            })
            ->rawColumns(['photo','name','parent']);
    }


}
