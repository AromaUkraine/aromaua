<?php


namespace App\DataTables;


use App\Models\Role;
use App\Models\Settings;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Yajra\DataTables\Services\DataTable;

class SettingsDataTable extends DataTable
{
    use DataTableTrait;

    public $columns =[
        [
            'data' => 'id',
            'title' => ''
        ],
        [
            'data' => 'name',
            'title' => 'cms.settings_name'
        ],
        [
            'data' => 'key',
            'title' => 'cms.settings_key'
        ],
        [
            'data' => 'group',
            'title' => 'cms.settings_group'
        ],
//        [
//            'data' => 'value',
//            'title' => 'cms.settings_value',
//            'orderable' => false
//        ],
    ];

    /**
     *  Необходим для показа пагинации
     * @var
     */
    public $totalCount;


    private $query;


    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $this->query = Settings::withTranslation()->newQuery();
    }

    public function dataTable(  )
    {
        return datatables()
            ->eloquent($this->query)
//            ->addColumn('value', function ($data){
//                if($data->component == 'image'):
//                    return "<img src='{$data->thumbs('300x200','value')}' height='150px' />";
//                endif;
//               // return $data->default ?? $data->value;
//            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action','value']);
    }

    /**
     * @param $data
     * @return string|null
     */
    protected function getActionColumn($data)
    {
        $buttons = null;

        if(\Auth::user()->can('root.settings.edit')){
            $buttons .= DataTableButton::make()->edit(route('root.settings.edit', $data->id));
        }

        if(\Auth::user()->can('root.settings.destroy')){
            $buttons .= DataTableButton::make()->delete(route('root.settings.destroy', $data->id));
        }

        return $buttons;
    }

}
