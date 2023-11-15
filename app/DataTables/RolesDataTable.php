<?php

namespace App\DataTables;


use App\Helpers\PermissionHelper;
use App\Models\Role;
use App\Traits\DataTableTrait;
use App\View\Components\Cms\Buttons\DataTableButton;
use App\View\Components\DataTable\Button;
use Carbon\Carbon;
use Yajra\DataTables\Services\DataTable;

class RolesDataTable extends DataTable
{
    use DataTableTrait;


    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns =[
        [
            'data' => 'id',
            'title' => '#'
        ],
        [
            'data' => 'name',
            'title' => 'role.name'
        ],
        [
            'data' => 'slug',
            'title' => 'slug'
        ],
        [
            'data' => 'description',
            'title' => 'cms.description'
        ],
        [
            'data' => 'created_at',
            'title' => 'role.created_at'
        ],
        [
            'data' => 'users',
            'title' => 'role.users',
            'orderable' => false
        ],

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

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable()
    {
        return datatables()
            ->eloquent($this->query)
            ->addColumn('users', function ($data){
                return "<a href='".route('admin.administration.index')."'> ".$data->users()->count()."</a>";
            })
            ->addColumn('created_at', function ($data) {
                return  Carbon::parse($data->created_at)->format('d.m.y');
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['users','action']);
    }

    /**
     * @param Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $model = new Role();
        $this->query = $model->newQuery();
    }

    /**
     * @param $data
     * @return string|null
     */
    protected function getActionColumn($data)
    {
        $buttons = null;

        if(\Auth::user()->can('admin.role.edit')){
            $buttons .= DataTableButton::make()->edit(route('admin.role.edit', $data->id));
        }

        if(\Auth::user()->can('admin.role_permissions.update') && $data->slug !== Role::DEFAULT_ROLE){
            $buttons .= DataTableButton::make([
                'name'=>__('cms.buttons.permission'),
                'icon'=>'bx bxs-check-shield',
                'class'=>'success'
            ])->edit(route('admin.role_permissions.show', $data->id));
        }else{
            $buttons .= DataTableButton::make(['class'=>'danger','icon'=>'bx bxs-shield-x'])->disabled()->toggleActive();
        }

        // Нельзя удалять роль администратора или собственную
        if(\Auth::user()->can('admin.role.destroy')){
            if($data->slug == Role::ADMINISTRATION_ROLE || ($data->slug == \Auth::user()->role->slug)){
                $buttons .= DataTableButton::make(['class'=>'danger'])->disabled()->delete();
            }else{
                $buttons .= DataTableButton::make()->delete(route('admin.role.destroy', $data->id));
            }
        }

        return $buttons;

    }
}
