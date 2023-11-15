<?php

namespace App\DataTables;


use App\Helpers\PermissionHelper;
use App\Models\Language;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;

use Yajra\DataTables\Services\DataTable;

class LanguageDataTable extends DataTable
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
            'orderable'=>false
        ],

        [
            'data' => 'name',
            'name' => 'translation.name',
            'title' => 'cms.language_name',

        ],
        [
            'data' => 'short_name',
            'name' => 'translation.short_name',
            'title' => 'cms.language_short_name',
        ],
        [
            'data' => 'short_code',
            'title' => 'cms.language_short_code',
        ],
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|mixed|null
     */
    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();

        if ($this->totalCount > 1) {
            $this->attributes = [
                'data-model' => Language::class,
                'class' => 'table  sortable',
                'data-url' => route('sortable')
            ];
        }
    }

    public function query(){

        $this->query = Language::withTrashed()
            ->join('language_translations as translation','languages.id','=','translation.language_id')
            ->select(['languages.id', 'languages.short_code', 'languages.order', 'languages.active', 'languages.deleted_at', 'translation.locale', 'translation.name', 'translation.short_name'])
            ->where('translation.locale',\App::getLocale())->newQuery();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
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
            ->rawColumns(['action','order']);
    }


    /**
     * @param $data
     * @return string|null
     */
    protected function getActionColumn($data)
    {
        $buttons = null;

        //$enabled = $data->deleted_at ? true : false;

        if (\Auth::user()->can('admin.language.edit')) {

            $buttons .= DataTableButton::make()->edit(route( 'admin.language.edit', $data->id));
        }

        if (\Auth::user()->can('admin.language.active') ) {

            if($data->short_code !== config('app.fallback_locale')) {
                $buttons .= DataTableButton::make()->toggleActive( $data->active , route( 'admin.language.active', $data->id));
            }else{
                $buttons .= DataTableButton::make(['class'=>'success'])->disabled()->toggleActive();
            }
        }


        return $buttons;
    }

}
