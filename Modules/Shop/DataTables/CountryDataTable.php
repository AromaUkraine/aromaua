<?php


namespace Modules\Shop\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Shop\Entities\Country;
use Yajra\DataTables\Services\DataTable;

class CountryDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    protected $query;


    public $columns = [
        [
            'data' => 'order',
            'title' => '#',
        ],

        [
            'data' => 'name',
            'title' => 'cms.country_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'shops_count',
            'title' => 'cms.shops_count',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'show_in_list',
            'title' => 'cms.show_in_list',
            'orderable' => false,
            'sortable' => false,
        ],
    ];


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => Country::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {
        $query = Country::withCount('shops')->newQuery();

        if (request()->has('trash')) {
            $query->onlyTrashed();
        }

        $this->query = $query;
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
            ->addColumn('shops_count', function ($data) {
                return $this->badge($data->shops_count);
            })
            ->addColumn('show_in_list', function ($data){
                return $this->checkbox('show', $data, $data->show, route('root.country.show', [
                    $data->id
                ]));
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'shops_count', 'show_in_list', 'action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request()->has('trash')) {
            if (\Auth::user()->can('root.country.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('root.country.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('root.country.edit')) {
                $buttons .= DataTableButton::make()->edit(route('root.country.edit', $data->id ));
            }

            if (\Auth::user()->can('root.country.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('root.country.active', $data->id));
            }

            if (\Auth::user()->can('root.country.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('root.country.destroy', $data->id));
            }

        }


        return $buttons;
    }

}
