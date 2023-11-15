<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\Currency;
use Yajra\DataTables\Services\DataTable;

class CurrencyDataTable extends DataTable
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
            'data' => 'name',
            'title' => 'cms.currency_name',
            'name' => 'name',
        ],
        [
            'data' => 'short_name',
            'title' => 'cms.currency_short_name',
            'name' => 'short_name',
        ],
        [
            'data' => 'iso',
            'title' => 'cms.currency_iso',
            'name' => 'iso',
            'orderable' => false
        ],
//        [
//            'data' => 'symbol',
//            'title' => 'cms.currency_symbol',
//            'name' => 'symbol',
//            'orderable' => false
//        ],
//        [
//            'data' => 'type',
//            'title' => 'cms.currency_type',
//            'name' => 'type',
//            'orderable' => false
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
        $this->query = Currency::select('currencies.*', 'currency_translations.name', 'currency_translations.short_name')
            ->join('currency_translations', function ($join){
                $join->on('currencies.id','=','currency_translations.currency_id')
                    ->where('currency_translations.locale', app()->getLocale());
            })->groupBy('currencies.iso');

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

            if (\Auth::user()->can('admin.currency.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('admin.currency.restore', $data->id ));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('admin.currency.edit')) {
                $buttons .= DataTableButton::make()->edit(route('admin.currency.edit', $data->id));
            }
            if (\Auth::user()->can('admin.currency.active')) {
                if($data->type == Currency::BASE_CURRENCY_TYPE) :
                    $buttons .= DataTableButton::make(['class'=>'success'])->disabled()->toggleActive();
                else :
                    $buttons .= DataTableButton::make()->toggleActive($data->active, route('admin.currency.active', $data->id));
                endif;
            }
            if (\Auth::user()->can('admin.currency.destroy')) {
//                $buttons .= '<form action="'.route('admin.currency.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';
                if($data->type == Currency::BASE_CURRENCY_TYPE) :
                    $buttons .= DataTableButton::make(['class'=>'danger'])->disabled()->delete();
                else :
                    $buttons .= DataTableButton::make()->delete(route('admin.currency.destroy', $data->id));
                endif;

            }

        }

        return $buttons;
    }
}
