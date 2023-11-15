<?php


namespace Modules\Catalog\DataTables;


use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\FeatureValue;
use Yajra\DataTables\Services\DataTable;

class FeatureValueDataTable extends DataTable
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
            'data' => 'order',
            'title' => '#',
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'cms.feature_kind_values',
            'orderable' => false,
            'sortable' => false,
        ],
    ];

    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => FeatureValue::class,
                'class' => 'table sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query()
    {
        $this->query = FeatureValue::join('feature_value_translations', function ($join){
            $join->on('feature_values.id','=','feature_value_translations.feature_value_id')
            ->where('locale', app()->getLocale());
        })
        ->select('feature_values.id as id','feature_values.order','feature_values.active', 'feature_value_translations.name')
        ->where('feature_kind_id', request()->kind->id);//->withTranslation();

        if (request('trash')) {
            $this->query->onlyTrashed();
        }

        $this->query->newQuery();
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
                    $query->where('name', 'like',  "%" . request('search')['value'] . "%");
                }
            })
            ->addColumn('order', function ($data) {
                return $this->getOrderColumn();
            })
            ->addColumn('name', function ($data) {
                if($data->color):
                    return "<span class='color-preview' style='background:{$data->color->code}'></span>".$data->name;
                endif;

                return $this->link(route('module.feature_value.edit', [request()->kind->id, $data->id]), $data->name);
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            })
            ->rawColumns(['order', 'name','action']);
    }


    protected function getActionColumn($data)
    {
        $buttons = null;

        if (request('trash')) {

            if (\Auth::user()->can('module.feature_value.restore')) {
                $buttons .= DataTableButton::make([
                    'name' => 'Восстановить',
                    'icon' => 'bx bx-reset',
                    'class' => 'success'
                ])->edit(route('module.feature_value.restore', [request()->kind->id, $data->id]));//btn  btn-icon  rounded-circle btn-outline-danger  ml-1
            }

        } else {

            if (\Auth::user()->can('module.feature_value.edit')) {
                $buttons .= DataTableButton::make()->edit(route('module.feature_value.edit', [request()->kind->id,$data->id]));
            }
            if (\Auth::user()->can('module.feature_value.active')) {
                $buttons .= DataTableButton::make()->toggleActive($data->active, route('module.feature_value.active',  $data->id));
            }
            if (\Auth::user()->can('module.feature_value.destroy')) {

//                $buttons .= '<form action="'.route('module.feature_value.destroy', $data->id).'" method="post">
//                    '.csrf_field().method_field('DELETE').'
//                    <button type="submit">delete</button>
//                </form>';

                $buttons .= DataTableButton::make()->delete(route('module.feature_value.destroy', $data->id));
            }

        }

        return $buttons;
    }
}
