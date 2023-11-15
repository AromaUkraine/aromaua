<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\FeatureKind;
use Yajra\DataTables\Services\DataTable;

class FeatureKindDataTable extends DataTable
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
//            'orderable' => false,
//            'sortable' => false,
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'cms.feature_kind_type',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'values_count',
            'title' => 'cms.feature_kind_values_count',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'directory',
            'title' => 'cms.feature_kind_directory',
            'orderable' => false,
            'sortable' => false
        ],
    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        $this->attributes = [
            'data-model' => FeatureKind::class,
            'class' => 'table sortable',
            'data-url' => route('sortable')
        ];
    }

    public function query()
    {
        $this->query = FeatureKind::select(
            'feature_kinds.id as id', 'feature_kinds.order','feature_kinds.active', 'feature_kinds.key',
            'feature_kind_translations.name as name','feature_kind_translations.locale'
        )->join('feature_kind_translations', function ($join){
            $join->on('feature_kinds.id','=','feature_kind_translations.feature_kind_id')
                ->where('feature_kind_translations.locale', app()->getLocale());
        })->withCount('feature_values');

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
                    $query->where('name', 'like',  "%" . request('search')['value'] . "%");
                }
            })
            ->addColumn('order', function ($data) {
                return $this->getOrderColumn();
            })
            ->addColumn('name', function ($data) {
                return $this->link(route('catalog.feature_kind.edit', $data->id), $data->name);
            })
            ->addColumn('values_count', function ($data) {
                if($data->key !== FeatureKind::IS_NUMBER) :
                    return $this->badge($data->feature_values_count);
                endif;
            })
            ->addColumn('directory', function ($data) {
                if($data->key !== FeatureKind::IS_NUMBER) :
                    return $this->link(route('module.feature_value.index', $data->id),__('cms.go_to_directory'));
                endif;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order','name','values_count','directory','action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('catalog.feature_kind.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('catalog.feature_kind.restore', ['kind' => $data->id]));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('catalog.feature_kind.edit')) {
                $buttons .= DataTableButton::make()->edit(route('catalog.feature_kind.edit', $data->id));
            }
            if (\Auth::user()->can('catalog.feature_kind.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('catalog.feature_kind.active', $data->id));
            }
            if (\Auth::user()->can('catalog.feature_kind.destroy')) {
                $buttons .= DataTableButton::make()->delete(route('catalog.feature_kind.destroy', $data->id));
            }

        }

        return $buttons;
    }
}
