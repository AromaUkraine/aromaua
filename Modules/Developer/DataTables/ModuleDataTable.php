<?php


namespace Modules\Developer\DataTables;


use App\Models\Component;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Yajra\DataTables\Services\DataTable;

class ModuleDataTable extends DataTable
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
            'data' => 'alias',
            'name' => 'alias',
            'title' => 'уникальный ключ',
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'Название',
        ],
        [
            'data' => 'description',
            'name' => 'description',
            'title' => 'описание',
        ],
        [
            'data' => 'type',
            'name' => 'type',
            'title' => 'Тип компонента',
        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query(){

        $this->query = (new Component)->newQuery();
    }

    /**
     * Build DataTable class.
     *
     */
    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;
        if(\Auth::user()->can('developer.module.edit')){
            $buttons .= DataTableButton::make()->edit(route('developer.module.edit', $data->id));
        }

        return $buttons;
    }
}
