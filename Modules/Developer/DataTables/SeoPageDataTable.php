<?php


namespace Modules\Developer\DataTables;


use App\Models\Page;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\DataTables\SeoCatalogDataTable;
use Modules\Catalog\Entities\SeoCatalog;
use Yajra\DataTables\Services\DataTable;

class SeoPageDataTable extends DataTable
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
            'data' => 'key',
            'title' => 'cms.unique_key',
            'orderable' => false
        ],
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

        $this->query = Page::where('data->entityable_type', SeoCatalog::class)->with('entity_features');//SeoCatalog::with(['page','category','entity_features']);
////
//        if (request('trash')) {
////            $this->query->onlyTrashed();
//            $this->query->onlyTrashed()->with(['page' => function ($query) {
//                $query->withTrashed();
//            },'category','entity_features'])->onlyTrashed();
//        }
        $this->query->newQuery();
    }

    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
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
            ->addColumn('key', function ($data){
                return $data->data['alias'] ?? null;
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action','feature']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if(\Auth::user()->can('developer.seo_page.edit')){
            $buttons .= DataTableButton::make()->edit(route('developer.seo_page.edit', $data->id));
        }
        if(\Auth::user()->can('developer.make_widget.create') && isset($data->data['alias'])){
            $buttons .= DataTableButton::make([
                'icon'=>'bx bx-plus',
               // 'class'=>'btn  btn-icon  rounded-circle btn-outline-success ml-1',
                'name' => 'создать виджет для страницы'
            ])->edit(route('developer.make_widget.create', [$data->id, 'alias'=>$data->data['alias']] ));
        }

        return $buttons;
    }

}
