<?php


namespace Modules\Developer\DataTables;


use App\Models\Menu;
use App\Models\Page;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\Entities\Template;
use Yajra\DataTables\Services\DataTable;

class FrontendMenuRootDataTable extends DataTable
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
            'data' => 'id',
            'name' => 'id',
            'title' => '#'
        ],
        [
            'data' => 'name',
            'title' => 'cms.page_name',
        ],
        [
            'data' => 'count_pages',
            'title' => 'cms.count_pages_in_menu',
        ]
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }

    public function query()
    {
        $this->query = Menu::frontend()
            ->with( 'childrenRecursive' )
            ->whereNull('parent_id');
    }

    public function dataTable()
    {
        $dt = datatables()
            ->eloquent($this->query)
            ->filter(function ($query)  {

                if (request()->has('search') && request('search')['value']) {
                    $query->where('name', 'like',  "%" . request('search')['value'] . "%");
                }
            });
        $dt->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('count_pages', function ($data){
                return $data::countChildPages($data);
            })
            ->addColumn('action', function ($data) {
                return $this->getActionColumn($data);
            });

        $dt->rawColumns(['name','status', 'action']);
        return $dt;
    }


    protected function getActionColumn($data)
    {
        $buttons = null;
        if(\Auth::user()->can('developer.frontend_menu_root.edit')){
            $buttons .= DataTableButton::make()->edit(route('developer.frontend_menu_root.edit', $data->id));
        }

        if(\Auth::user()->can('developer.frontend_menu_root.destroy')){
            $buttons .= DataTableButton::make()->delete(route('developer.frontend_menu_root.destroy', $data->id));
        }

        return $buttons;
    }

}
