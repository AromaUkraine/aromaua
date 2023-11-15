<?php

namespace App\Http\Controllers\Cms;


use App\Helpers\PermissionHelper;
use App\Models\Role;
use App\Events\DeleteRoleEvent;
use App\Http\Requests\RoleRequest;
use App\DataTables\RolesDataTable;
use App\Http\Controllers\Controller;


class RoleController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param RolesDataTable $dataTable
     * @return mixed
     */
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render(PermissionHelper::CMS.'.role.index');
    }


    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view(PermissionHelper::CMS.'.role.create')->with(['roles'=>(new Role())->notCreatedAdministrationRoles()]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(RoleRequest $request)
    {
        $request->except('_token');

        Role::create($request->all());

        toastr()->success(__('toastr.created.message'));

        return redirect(route('admin.role.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return \Illuminate\View\View
     */
    public function edit(Role $role)
    {

        return view(PermissionHelper::CMS.'.role.edit', compact('role'))
            ->with(['roles'=>Role::administration()->get()]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param Role $role
     * @return \Illuminate\Routing\Redirector
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->all());

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.role.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        event( new DeleteRoleEvent( $role ) );

        return response()->json(['message'=>__('toastr.deleted.message')]);

    }
}
