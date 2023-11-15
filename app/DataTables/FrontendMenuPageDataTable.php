<?php


namespace App\DataTables;


use App\Models\Menu;
use App\Models\Page;
use App\Traits\DataTableTrait;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\Entities\Template;
use Yajra\DataTables\Services\DataTable;

class FrontendMenuPageDataTable extends DataTable
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
            'data' => 'status',
            'title' => '',
        ],
        [
            'data' => 'name',
            'title' => 'cms.page_name',
        ]
    ];

    public function __construct()
    {
        $this->query();
        $this->totalCount = $this->query->count();
    }


    public function query()
    {
        $this->query = Page::whereIn('pageable_type', [Template::class, SeoCatalog::class, ProductCategory::class])
            ->join('page_translations', function ($join) {
                $join->on('page_translations.page_id','=', 'pages.id')
                    ->where('locale', app()->getLocale());
            })
            ->leftJoin('menus', function ($join) {
                $join->on('menus.page_id','=','pages.id')
                    ->where('from', Menu::FRONTEND )
                    ->where('parent_id', request()->menu->id);
            })
            ->select( 'menus.id as status', 'pages.id', 'page_translations.name');
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
            $dt->orderColumn('status', function ($query, $order) {
                    $query->orderBy('status', $order);
                })
            ->addColumn('status', function ($data) {
                if($data->status) :
                    return $this->checkbox('remove', $data, true, route('root.frontend_menu.store', [
                        'menu'=> request()->menu->id,
                        'page'=>$data->id,
                        'status'=>'remove'
                    ]));
                else:
                    return $this->checkbox('add', $data, false, route('root.frontend_menu.store', [
                        'menu'=> request()->menu->id,
                        'page'=>$data->id,
                        'status'=>'add'
                    ]));
                endif;
            })->addColumn('name', function ($data) {
                return $data->name;
            })

            ->addColumn('action', function ($data) {
                return null;//$this->getActionColumn($data);
            });

        $dt->rawColumns(['name','status', 'action']);
        return $dt;
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        if($data->status) :
            $buttons .= '<form action="' . route('root.frontend_menu.store', [
                    request()->menu->id, $data->id, 'remove'
                ]) . '" method="post">
                    ' . csrf_field() . method_field('POST') . '
                    <button type="submit">remove</button>
             </form>';
        else:
            $buttons .= '<form action="' . route('root.frontend_menu.store', [
                    request()->menu->id, $data->id, 'add'
                ]) . '" method="post">
                    ' . csrf_field() . method_field('POST') . '
                    <button type="submit">add</button>
             </form>';
        endif;


        return $buttons;
    }

}
