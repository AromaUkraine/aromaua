<?php


namespace Modules\Shop\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Shop\Entities\Shop;
use Yajra\DataTables\Services\DataTable;

class ShopDataTable extends DataTable
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
            'data' => 'country',
            'title' => 'cms.country_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'name',
            'title' => 'cms.shop_name',
            'orderable' => false,
            'sortable' => false,
        ],
        [
            'data' => 'central_shop',
            'title' => 'cms.central_shop',
            'orderable' => false,
            'sortable' => false,
        ],
        [
           'data' => 'map_exist',
           'title' => 'cms.google_map',
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
                'data-model' => Shop::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {
        $query = Shop::with(['city','country']);

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
        $datatable->filter(function ($query) {

            if (request()->has('trash')) {
                $query->onlyTrashed();
            }

            if (request()->has('search') && request('search')['value']) {

                $query->whereHas('country', function ($q) {
                    $q->join('country_translations', function($join)  {
                        $join->on('countries.id','=','country_translations.country_id')
                            ->where('country_translations.name', 'like',  "%" . request('search')['value'] . "%");
                    });
                })
                ->orWhereTranslationLike('name', "%" . request('search')['value'] . "%");
            }
        });

        return $datatable
            ->addColumn('order', function ($data) {
                return ($this->totalCount > 1) ? "<i class=\"bx bx-move-vertical move\"></i>" : '';
            })
            ->addColumn('country', function ($data) {
                return $this->link(route('root.country.edit', $data->country->id), $data->country->name);
            })
            ->addColumn('name', function($data){
                return $this->link(route('root.shop.edit', $data->id), $data->name);
            })
            ->addColumn('central_shop', function ($data){
                return $this->checkbox('change', $data, ($data->default),
                    route('root.shop.change', $data->id));
            })
            ->addColumn('map_exist', function($data){
                if($data->map) {
                    return $this->link(
                        route('module.entity_map.index', [$data->getTable(), $data->id]),
                        "<i class='fas fa-map-marked-alt fa-2x'></i>");
                }

            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'city', 'country', 'name', 'central_shop', 'map_exist', 'action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {
            if (\Auth::user()->can('root.shop.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => __('cms.restore'),//'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('root.shop.restore', $data->id));
            }
        } else {

            if (\Auth::user()->can('root.shop.edit')) {
                $buttons .= DataTableButton::make()->edit(route('root.shop.edit', $data->id ));
            }

            if (\Auth::user()->can('root.shop.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('root.shop.active', $data->id));
            }

            if (\Auth::user()->can('root.shop.destroy')) {

//                $buttons .= '<form action="'.route('module.banner.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('root.shop.destroy', $data->id));
            }

        }

        return $buttons;
    }
}
