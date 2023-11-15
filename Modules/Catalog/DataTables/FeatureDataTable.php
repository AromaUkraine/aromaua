<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\Feature;
use Yajra\DataTables\Services\DataTable;

class FeatureDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;


    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
//        [
//            'data' => 'id',
//            'name' => 'id',
//            'title' => '#',
//        ],
        [
            'data' => 'order',
            'title' => '#',
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'cms.feature_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'feature_kind_name',
            'name' => 'cms.feature_kind_name',
            'title' => 'kind.type',
        ],
        [
            'data' => 'filter',
            'name' => 'filter',
            'title' => 'cms.feature_kind_in_filter',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'preview',
            'name' => 'preview',
            'title' => 'cms.feature_kind_in_preview',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'page',
            'name' => 'page',
            'title' => 'cms.feature_kind_in_page',
            'orderable' => false,
            'sortable' => false,
        ],
    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        $this->attributes = [
            'data-model' => Feature::class,
            'class' => 'table sortable',
            'data-url' => route('sortable')
        ];
    }

    public function query()
    {
        $this->query = Feature::select(
            'features.id as id', 'features.order','features.active',
            'features.filter', 'features.preview','features.page',
            'feature_translations.name as name',
            'feature_kind_translations.name as feature_kind_name', 'feature_kind_translations.locale'
        )->join('feature_translations', function ($join){
            $join->on('features.id','=','feature_translations.feature_id')
            ->where('locale', app()->getLocale());
        })
        ->join('feature_kinds', function ($join){
            $join->on('feature_kinds.id','=','features.feature_kind_id')
                ->join('feature_kind_translations', function ($join){
                    $join->on('feature_kinds.id','=','feature_kind_translations.feature_kind_id')
                        ->where('feature_kind_translations.locale', app()->getLocale());
                });
        });

        if (request('trash')) {
            $this->query->onlyTrashed();
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
                    $query->where('name', 'like',  "%" . request('search')['value'] . "%")
                    ->orWhere('feature_kind_name', 'like',  "%" . request('search')['value'] . "%");
                }
            })
            ->addColumn('order', function ($data) {
                return $this->getOrderColumn();
            })
            ->addColumn('name', function ($data) {
                return $this->link(route('catalog.feature.edit', $data->id), $data->name);
            })
            ->addColumn('feature_kind_name', function ($data) {
                return $data->feature_kind_name;
            })
            ->addColumn('filter', function ($data) {
                return $this->checkbox('filter', $data);
            })
            ->addColumn('preview', function ($data) {
                return $this->checkbox('preview', $data);
            })
            ->addColumn('page', function ($data) {
                return $this->checkbox('page', $data);
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order','name','filter','preview','page','action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('catalog.feature.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('catalog.feature.restore',  $data->id));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('catalog.feature.edit')) {
                $buttons .= DataTableButton::make()->edit(route('catalog.feature.edit', $data->id));
            }
            if (\Auth::user()->can('catalog.feature.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('catalog.feature.active', $data->id));
            }
            if (\Auth::user()->can('catalog.feature.destroy')) {
                $buttons .= DataTableButton::make()->delete(route('catalog.feature.destroy', $data->id));
            }

        }

        return $buttons;
    }
}
