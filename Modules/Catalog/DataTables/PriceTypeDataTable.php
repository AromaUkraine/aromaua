<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\PriceType;
use Yajra\DataTables\Services\DataTable;

class PriceTypeDataTable extends DataTable
{
    use DataTableTrait;

    public $attributes;

    public $totalCount;

    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns = [
        [
            'data' => 'id',
            'name' => 'id',
            'title' => '#',
        ],
        [
            'data' => 'key',
            'title' => 'cms.price_type_key',
        ],
        [
            'data' => 'currency_name',
            'title' => 'cms.currency_name',
        ],
//        [
//            'data' => 'currency_short_name',
//            'title' => 'cms.currency_short_name',
//            'name' => 'short_name',
//        ],
//        [
//            'data' => 'name',
//            'title' => 'cms.price_type_name',
//            'name' => 'name',
//        ],
    ];


    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $this->query = PriceType::with('currency');

        if (request('trash')) {
            $this->query->onlyTrashed();
        }

        $this->query->newQuery();
    }

    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->filter(function ($query) {
                if (request()->has('search') && request('search')['value']) {
                    $query->where('key', 'like',  "%" . request('search')['value'] . "%")
                        ->orWhereHas('currency', function ($query){
                            $query->where('iso', 'like',  "%" . request('search')['value'] . "%");
                        });
                }
            })
            ->addColumn('currency_name', function ($data) {
                return $data->currency->name;
            })
            ->addColumn('currency_short_name', function ($data) {
                return $data->currency->short_name;
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['photo','name','action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('admin.price_type.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('admin.price_type.restore', $data->id ));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('admin.price_type.edit')) {
                $buttons .= DataTableButton::make()->edit(route('admin.price_type.edit', $data->id));
            }
            if (\Auth::user()->can('admin.price_type.active')) {
                if($data->key == PriceType::DEFAULT_KEY) :
                    $buttons .= DataTableButton::make(['class'=>'success'])->disabled()->toggleActive();
                else :
                    $buttons .= DataTableButton::make()->toggleActive($data->active, route('admin.price_type.active', $data->id));
                endif;
            }
            if (\Auth::user()->can('admin.price_type.destroy')) {
//                $buttons .= '<form action="'.route('admin.price_type.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';
                if($data->key == PriceType::DEFAULT_KEY) :
                    $buttons .= DataTableButton::make(['class'=>'danger'])->disabled()->delete();
                else :
                    $buttons .= DataTableButton::make()->delete(route('admin.price_type.destroy', $data->id));
                endif;

            }

        }

        return $buttons;
    }
}
