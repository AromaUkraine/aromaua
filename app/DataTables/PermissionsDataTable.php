<?php

namespace App\DataTables;

use App\Helpers\PermissionHelper;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\DataTables;

class PermissionsDataTable extends DataTables
{

    /**
     * Массив всех существующих защищенных доступов
     * @var array
     */
    protected $permissions;

    /**
     * Массив всех существующих методов в защищенных доступах
     * @var array
     */
    public $actions;

    /**
     * Результирующий массив защищенных доступов и методов
     * @var array
     */
    public $tableData;


    public function __construct()
    {
        $this->permissions = collect(PermissionHelper::getAllPermissions());
        $this->actions = collect();
        $this->permissions->unique('action')->map(function ($item){
            $this->actions->push($item['action']);
        });
        $perm_group = $this->permissions->groupBy('controller');

        $perm_group->map(function ($permissions, $key){
            foreach ($this->actions as $action){
                $find = $permissions->where('action', $action)->first();
                if($find) {
                    $this->tableData[$key][$action] = [
                            'action'=>$action,
                            'slug'=>$find['slug'],
                            'id'=>$find['id']
                        ];
                }else{
                    $this->tableData[$key][$action] = $find;
                }
            }
        });
    }
}
