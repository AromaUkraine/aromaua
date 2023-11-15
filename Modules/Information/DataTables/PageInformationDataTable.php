<?php


namespace Modules\Information\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Information\Entities\Information;
use Yajra\DataTables\Services\DataTable;

class PageInformationDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;

    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
//            'orderable' => false,
//            'sortable' => false,
        ],
        [
            'data' => 'title',
            'title' => 'cms.information_title',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'values_count',
            'title' => 'cms.values_count',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'children',
            'title' => 'cms.information_children',
            'orderable' => false,
            'sortable' => false
        ],
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => Information::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {

        $query = Information::where('parent_page_id', request()->page->id)
            ->withPageComponent(request()->page_component->alias);


        if (request('trash')) {
            $query->onlyTrashed();
        }

        $this->query = $query->newQuery();
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
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('values_count', function ($data) {
                return null;
            })
            ->addColumn('children', function ($data) {
                return $this->link(route('module.page_info_child.index', [$data->parent_page_id, $data->component->alias, $data->id]),__('cms.go_to_directory'));
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'values_count', 'children','action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('module.page_info.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.page_info.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('module.page_info.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.page_info.edit', [
                    request()->page->id,
                    $data->component->alias,
                    $data->id
                ]));
            }

            if (\Auth::user()->can('module.page_info.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.page_info.active', $data->id));
            }

            if (\Auth::user()->can('module.page_info.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.page_info.destroy', $data->id));
            }

        }


        return $buttons;
    }

}
