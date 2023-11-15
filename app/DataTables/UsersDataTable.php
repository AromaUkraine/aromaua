<?php

namespace App\DataTables;

use App\Helpers\PermissionHelper;
use App\Models\Role;
use App\Models\User;


use Carbon\Carbon;
use App\Traits\DataTableTrait;
use Yajra\DataTables\Services\DataTable;
use App\View\Components\Cms\Buttons\DataTableButton;

class UsersDataTable extends DataTable
{
    use DataTableTrait;

    /**
     * Замена стандартному методу getColumns ( реализация в DataTableTrait )
     * @var array
     */
    public $columns =[
        [
            'data' => 'id',
            'title' => ''
        ],
        [
            'data' => 'login',
            'title' => 'user.name'
        ],
        [
            'data' => 'email',
            'title' => 'user.email'
        ],
        [
            'data' => 'created_at',
            'title' => 'user.created_at'
        ],
        [
            'data' => 'roles',
            'name' => 'roles.name',
            'title' => 'user.roles',
            'orderable' => false
        ],
    ];

    /**
     *  Необходим для показа пагинации
     * @var
     */
    public $totalCount;


    private $query;


    protected $roles = [];


    public function __construct()
    {
        $this->query();
        $this->setRoles();
        $this->totalCount = $this->query->count();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(  )
    {
        return datatables()
            ->eloquent($this->query)
            ->addColumn('roles', function ($data){
                return implode(', ',$data->roles->pluck('name')->toArray());
            })
            ->addColumn('created_at', function ($data) {
                return Carbon::parse($data->created_at)->format('d.m.y');
            })
            ->addColumn('action', function($data){
                return $this->getActionColumn($data);
            })
            ->rawColumns(['action']);
    }


    public function query()
    {
        $this->query = User::withAndWhereHas('roles',function($query){
            $query->whereIn('slug', $this->getRoles());
        })->distinct()->newQuery();
    }


    protected function setRoles(){}

    private function getRoles()
    {
        return $this->roles;
    }



    /**
     * Get columns.
     * Пример метода getColumns
     *
    protected function getColumns()
    {
        return [
            Column::make('id')->title(''),
            Column::make('name')->title(__('cms.user.name')),
            Column::make('email','email')->title(__('cms.user.email')),
            Column::make('created_at')->title(__('cms.user.created_at')),
            Column::make('roles', 'roles.name')->title(__('cms.user.roles'))->orderable(false),
            Column::computed('action')
            ->title('')
            ->exportable(false)
            ->printable(false)
            ->addClass('text-center text-nowrap'),
        ];
    }
     */
}
