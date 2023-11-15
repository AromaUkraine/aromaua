<?php


namespace Modules\Developer\DataTables;


use App\Models\EntityComponent;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Yajra\DataTables\Services\DataTable;

class EntityComponentDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    private $query;

    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'table',
            'name' => 'table',
            'title' => 'Имя таблицы',
        ],
        [
            'data' => 'model',
            'name' => 'model',
            'title' => 'Путь к модели',
        ],
//        [
//            'data' => 'name',
//            'name' => 'name',
//            'title' => 'Название',
//        ],
        [
            'data' => 'slug',
            'name' => 'slug',
            'title' => 'Имя роута',
        ],
        [
            'data' => 'route_key',
            'name' => 'route_key',
            'title' => 'Роут записи',
        ],
        [
            'data' => 'relation',
            'name' => 'relation',
            'title' => 'Метод',
        ],
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => EntityComponent::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query(){
        $this->query = (new EntityComponent)->newQuery();
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
            ->addColumn('name', function($data){
                return __($data->name);
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;
        if(\Auth::user()->can('developer.entity_component.edit')){
            $buttons .= DataTableButton::make()->edit(route('developer.entity_component.edit', $data->id));
        }
        if(\Auth::user()->can('developer.entity_component.destroy')){
//             $buttons .= '<form action="'.route('developer.entity_component.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';
            $buttons .= DataTableButton::make()->delete(route('developer.entity_component.destroy', $data->id));
        }

        return $buttons;
    }
}
