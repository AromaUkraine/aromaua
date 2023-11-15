<?php

namespace App\Http\Controllers\Cms;



use App\Helpers\PermissionHelper;
use App\Models\Role;
use App\Models\User;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use App\Events\ChangeUserRoleEvent;
use App\Http\Controllers\Controller;



class UserController extends Controller
{

    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('cms.user.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cms.user.create')->with([
            'roles'=>Role::all(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return \Illuminate\Routing\Redirector
     */
    public function store(UserRequest $request)
    {

        $user = User::create([
            'login'=>$request->login,
            'email'=>$request->email,
            'password'=>\Hash::make($request->password),
        ]);

        $role = Role::findOrFail((int) $request->role_id);

        event( new ChangeUserRoleEvent( $user, $role ) );

        toastr()->success(__('toastr.created.message'));

        return redirect(route('admin.user.index'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('cms.user.edit')->with([
            'roles'=>Role::all(),
            'user'=>$user
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->all());

        $role = Role::findOrFail((int) $request->role_id);

        // если у пользователя изменилась роль
        if(!$user->roles->contains($role)){
            event( new ChangeUserRoleEvent( $user, $role ) );
        }

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.user.index'));
    }


    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
       $user->delete();

       return response()->json(['message'=>__('toastr.deleted.message')]);
    }
}
