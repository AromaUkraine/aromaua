<?php


namespace Modules\Shop\DataTables;


use App\Models\Role;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Shop\Entities\City;
use Yajra\DataTables\Services\DataTable;

class CityDataTable extends DataTable
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
            'title' => 'cms.city_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'shops_count',
            'title' => 'cms.shops_count',
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
                'data-model' => City::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {
        $query = City::withCount('shops')->newQuery();

        if (request('trash')) {
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
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'shops_count', 'action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('developer.city.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('developer.city.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('developer.city.edit')) {
                $buttons .= DataTableButton::make()->edit(route('developer.city.edit', $data->id ));
            }

            if (\Auth::user()->can('developer.city.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('developer.city.active', $data->id));
            }

            if (\Auth::user()->can('developer.city.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('developer.city.destroy', $data->id));
            }

        }


        return $buttons;
    }

}
