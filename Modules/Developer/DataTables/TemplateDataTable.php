<?php

namespace Modules\Developer\DataTables;


use App\Models\PageComponent;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Developer\Entities\Template;
use Yajra\DataTables\Services\DataTable;

class TemplateDataTable extends DataTable
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
            'data'=>'id',
            'name'=>'id',
            'title'=>'ID'
        ],
        [
            'data' => 'name',
            'name' => 'name',
            'title' => 'template.name',
        ],
        [
            'data' => 'is_main',
            'name' => 'is_main',
            'title' => 'template.main',
        ],
//        [
//            'data' => 'components',
//            'title' => 'template.components'
//        ],
        [
            'data' => 'module',
            'title' => 'page.module',
        ],
        [
            'data' => 'widgets',
            'title' => 'page.widgets',
        ],
//        [
//            'data' => 'data',
//            'title' => 'json'
//        ],
    ];


    private $query;

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query(){

        $this->query = (new Template)->orderBy('is_main', 'desc')->newQuery();
    }

    /**
     * Build DataTable class.
     *
     */
    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->addColumn('is_main', function($data){
                return ($data->is_main) ? 'главная': '';
            })
            ->addColumn('module', function($data){

                $module = collect($data->components)->where('type', PageComponent::TYPE_MODULE)->first();
                if($module){
                    return"<div class=\"badge badge-pill badge-light-secondary mr-1 mb-1\">{$module['name']}</div>";
                }
            })
            ->addColumn('widgets', function($data){
                $widgets = collect($data->components)->where('type', PageComponent::TYPE_WIDGET);
                $list = '';
                if($widgets->count()){
                    foreach ($widgets as $widget) {
                        $list .= "<div class=\"badge badge-pill badge-light-secondary mr-1 mb-1\">{$widget['name']}</div>";
                    }
                }
                return $list;
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['module','widgets','action']);
    }

    protected function getActionColumn($data)
    {
        $buttons = null;
        if(\Auth::user()->can('developer.template.edit')){
            $buttons .= DataTableButton::make()->edit(route('developer.template.edit', $data->id));
        }


        return $buttons;
    }
}
