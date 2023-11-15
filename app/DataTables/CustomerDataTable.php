<?php


namespace App\DataTables;


use App\Models\Role;

class CustomerDataTable extends UsersDataTable
{
    protected function setRoles()
    {
        $this->roles = [Role::DEFAULT_ROLE];
    }

    protected function getActionColumn($data)
    {
        $buttons = null;

        return $buttons;
    }
}
