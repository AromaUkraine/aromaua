<?php


namespace Modules\Information\DataTables;


use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Information\Entities\Information;

class PageInformationChildrenDataTable extends PageInformationDataTable
{

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
            'data' => 'description',
            'title' => 'cms.information_description',
            'orderable' => false,
            'sortable' => false,
        ],
    ];

    public function query()
    {
        $query = Information::where('parent_information_id', request()->parent->id);

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
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('module.page_info_child.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.page_info_child.restore', [
                    request()->page->id,
                    request()->page_component->alias,
                    request()->parent,
                    $data->id
                ]));
            }
        } else {

            if (\Auth::user()->can('module.page_info_child.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.page_info_child.edit', [
                    request()->page->id,
                    request()->page_component->alias,
                    request()->parent,
                    $data->id
                ]));
            }

            if (\Auth::user()->can('module.page_info_child.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.page_info_child.active', $data->id));
            }

            if (\Auth::user()->can('module.page_info_child.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.page_info_child.destroy', $data->id));
            }

        }


        return $buttons;
    }
}
