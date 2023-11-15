<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\SeoCatalog;
use Yajra\DataTables\Services\DataTable;

class SeoCatalogDataTable extends DataTable
{

    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;


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
            'title' => 'cms.name',
            'orderable' => false
        ],
        [
            'data' => 'category',
            'title' => 'cms.product_category',
            'orderable' => false
        ],
//        [
//            'data' => 'is_brand',
//            'title' => 'cms.brand',
//            'orderable' => false
//        ],
        [
            'data' => 'feature',
            'title' => 'cms.feature',
            'orderable' => false
        ],

    ];

    public function __construct()
    {

        $this->query();
        $this->totalCount = $this->query->count();
        \Session::put('element_per_page', 15);
    }


    public function query()
    {

        $this->query = SeoCatalog::with(['page','category','entity_features']);

        if (request('trash')) {
            $this->query->onlyTrashed()->with(['page' => function ($query) {
                $query->withTrashed();
            },'category','entity_features'])->onlyTrashed();
        }

        $this->query->newQuery();
    }


    public function dataTable()
    {

        return datatables()
            ->eloquent($this->query)
            ->filter(function ($query)  {

                if (request()->has('trash')) {
                    $query->onlyTrashed();
                }

                if (request()->has('search') && request('search')['value']) {
                    $query->whereHas('page', function ($q) {
                        $q->join('page_translations', function($join)  {
                            $join->on('pages.id','=','page_translations.page_id')
                                ->where('name', 'like',  "%" . request('search')['value'] . "%");
                        });
                    })->orWhereHas('category',function ($q) {
                        $q->whereHas('page', function ($q)  {
                            $q->join('page_translations', function ($join)  {
                                $join->on('pages.id', '=', 'page_translations.page_id')
                                    ->where('name', 'like',  "%" . request('search')['value'] . "%");
                            });
                        });
                    });
                }
                if(request()->has('is_brand')) {
                    $query->where('is_brand', true);
                }
                if(request()->has('feature_id') && !request()->has('feature_value_id')) {
                    $query->whereHas('entity_features', function ($q){
                        $q->where('feature_id', request()->feature_id);
                    });
                }
                if(!request()->has('feature_id') && request()->has('feature_value_id')) {
                    $query->whereHas('entity_features', function ($q){
                        $q->where('feature_value_id', request()->feature_value_id);
                    });
                }
                if(request()->has('feature_id') && request()->has('feature_value_id')) {
                    $query->whereHas('entity_features', function ($q){
                        $q->where('feature_id', request()->feature_id);
                        $q->where('feature_value_id', request()->feature_value_id);
                    });
                }
            })
            ->addColumn('name', function ($data) {
                if(isset($data->page)):
                    return  $this->link(route('catalog.seo_catalog.edit', $data->id), $data->page->name);
                endif;
            })

            ->addColumn('category', function ($data){
                if(isset($data->category)):
                    return  $this->link(route('catalog.product_category.edit',  $data->category->id), $data->category->page->name);
                endif;

                return null;
            })
//            ->addColumn('is_brand', function ($data){
//                if($data->is_brand):
//                    return $this->badge($data->is_brand,'success', "<i class='fas fa-check'></i>");
//                endif;
//
//                return null;
//            })
            ->addColumn('feature', function ($data){
                $res = '';
                if(isset($data->entity_features)){
                    $collection = $data->entity_features->map(function ($entity_feature)  {
                        $value = $entity_feature->feature->feature_kind->feature_values->where('id',$entity_feature->feature_value_id)->first();
                        return [
                            'feature_id' =>$entity_feature->feature_id,
                            'feature_name' =>$entity_feature->feature->name,
                            'values_name' => $value->name
                        ];
                    });

                    $collection->groupBy('feature_name')->map(function ($f, $key) use(&$res){
                        $res .= $key.' : '.$f->implode('values_name', ','). '<br>';
                    });

                }
                return $res;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['name','action','category','is_brand','feature']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('catalog.seo_catalog.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('catalog.seo_catalog.restore', $data->id ));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('catalog.seo_catalog.edit')) {
                $buttons .= DataTableButton::make()->edit(route('catalog.seo_catalog.edit', $data->id));
            }
            if (\Auth::user()->can('catalog.seo_catalog.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->page->active, route('catalog.seo_catalog.active', $data->id));
            }
            if (\Auth::user()->can('catalog.seo_catalog.destroy')) {
//                $buttons .= '<form action="'.route('catalog.product.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';
                $buttons .= DataTableButton::make()->delete(route('catalog.seo_catalog.destroy', $data->id));
            }

        }

        return $buttons;
    }

}
