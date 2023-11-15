<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\PermissionsDataTable;
use App\Events\ChangeRolePermissionsEvent;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RolePermissionsController extends Controller
{

    public function show(Role $role, PermissionsDataTable $dataTable)
    {
        $role_permissions = $role->permissions->toArray();
        $tableData = $dataTable->tableData;
        $actions = $dataTable->actions;

        return view(PermissionHelper::CMS.'.role_permissions.show', [
            'role'=>$role,
            'used_permissions'=>$role_permissions,
            'tableData'=>$tableData,
            'actions'=>$actions
        ]);
    }


    public function update(Request $request, Role $role)
    {
        $role->permissions()->detach();
        $role->permissions()->attach($request->permissions);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.role.index'));
    }

}
