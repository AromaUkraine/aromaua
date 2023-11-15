<?php


namespace Modules\Banner\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Banner\Entities\Banner;
use Yajra\DataTables\Services\DataTable;

class PageBannerDataTable extends DataTable
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
            'data' => 'order',
            'title' => '#',
            'orderable' => false
        ],
        [
            'data' => 'image',
            'title' => 'cms.banner_image',
        ],
        [
            'data' => 'name',
            'title' => 'cms.banner_name',
        ],
        [
            'data' => 'link',
            'title' => 'cms.banner_link',
        ],
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => Banner::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {

        $query = Banner::where('parent_page_id', request()->page->id)
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
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {

                }
            })
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('image', function ($data) {
                return "<img src='{$data->thumbs('300x200')}' height='150px' />";
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'image', 'action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('module.page_banner.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.page_banner.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('module.page_banner.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.page_banner.edit', [
                    request()->page->id,
                    $data->component->alias,
                    $data->id
                ]));
            }

            if (\Auth::user()->can('module.page_banner.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.page_banner.active', $data->id));
            }

            if (\Auth::user()->can('module.page_banner.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.page_banner.destroy', $data->id));
            }

        }


        return $buttons;
    }
}
