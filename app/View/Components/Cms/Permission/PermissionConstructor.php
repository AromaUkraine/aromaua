<?php

namespace App\View\Components\Cms\Permission;

use App\Helpers\PermissionHelper;
use Illuminate\View\Component;

class PermissionConstructor extends Component
{
    public $permissions;

    public $model;

    public $name;
    /**
     * @var bool
     */
    public $required;

    /**
     * PermissionConstructor constructor.
     * @param $model
     * @param $name
     * @param bool $required
     */
    public function __construct($model, $name, $required = false)
    {
        $this->permissions = PermissionHelper::getAllPermissions('action','index');
        $this->model = $model;
        $this->name = $name;
        $this->required = $required;
    }

    public function setSelected($item)
    {
        if($this->model && $this->model->permission) {
            return ($item['id'] == $this->model->permission->id) ? 'selected': '';
        }
        return "";
    }

    /**
     * @return \Illuminate\View\View|string|void
     * @throws \Exception
     */
    public function render()
    {
        throw new \Exception('This is just a class constructor');
    }
}
