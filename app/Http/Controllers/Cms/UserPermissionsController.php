<?php

namespace App\Http\Controllers\Cms;

use App\DataTables\PermissionsDataTable;
use App\Events\ChangeUserPermissionsEvent;
use App\Helpers\ArrayHelper;
use App\Helpers\PermissionHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class UserPermissionsController extends Controller
{
    /**
     * @param User $user
     * @param PermissionsDataTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(User $user, PermissionsDataTable $dataTable)
    {
        $user_permissions = $user->getAllPermissions()->toArray();
        $tableData = $dataTable->tableData;
        $actions = $dataTable->actions;

        return view('cms.user_permissions.show', [
            'user'=>$user,
            'used_permissions'=>$user_permissions,
            'tableData'=>$tableData,
            'actions'=>$actions
        ]);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, User $user)
    {

        $user->permissions()->detach();
        $user->permissions()->attach($request->permissions);

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.administration.index'));
    }

}
