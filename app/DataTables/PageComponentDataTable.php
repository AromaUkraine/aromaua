<?php


namespace App\DataTables;


use App\Models\PageComponent;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Yajra\DataTables\Services\DataTable;

class PageComponentDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;

    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
            'orderable' => false
        ],
        [
            'data' => 'name',
            'title' => 'cms.page_component_name',
        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => PageComponent::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {

        $this->query = PageComponent::whereHas('page', function ($query) {
            $query->where('page_id', request()->page->id)->where('type', PageComponent::TYPE_WIDGET);
        });
    }

    public function dataTable()
    {
        $datatable = datatables()->eloquent($this->query);

        /** добавлено для сортировки **/
        if ($this->totalCount > 1) {

            $datatable
                ->setRowClass('row-sort')
                ->setRowAttr([
                    'data-id' => function ($data) {
                        return $data->id;
                    },
                ]);
        }

        return $datatable
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action', 'order']);
    }


    /**
     * @param $data
     * @return string|null
     */
    protected function getActionColumn($data)
    {
        $buttons = null;

        if (\Auth::user()->can('module.page_component.active')) {

            $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.page_component.active', $data->id));
        }

        return $buttons;
    }
}
