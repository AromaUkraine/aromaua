<?php


namespace App\Http\Controllers\Cms;


use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Events\ChangeUserRoleEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Bridge\AccessToken;
use App\DataTables\AdministrationDataTable;
use App\Http\Requests\ChangePasswordRequest;

class AdministrationController extends Controller
{
    public function index(AdministrationDataTable $dataTable)
    {
        return $dataTable->render('cms.administration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('cms.administration.create')->with([
            'roles'=>Role::administration()->get(),
        ]);
    }

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

        return redirect(route('admin.administration.index'));
    }



    public function edit(User $administration)
    {

        return view('cms.administration.edit')->with([
            'roles'=>Role::administration()->get(),
            'user'=>$administration
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $administration
     * @return \Illuminate\Routing\Redirector
     */
    public function update(UserRequest $request, User $administration)
    {

        $administration->update($request->all());

        $role = Role::findOrFail((int) $request->role_id);

        // если у пользователя изменилась роль
        if(!$administration->roles->contains($role)){
            event( new ChangeUserRoleEvent( $administration, $role ) );
        }

        toastr()->success(__('toastr.updated.message'));

        return redirect(route('admin.administration.index'));
    }


    public function change_password(ChangePasswordRequest $request, User $user)
    {

        $user->update(['password'=> Hash::make($request->new_password)]);

        toastr()->success(__('cms.Password changed successfully'));

        return redirect(route('admin.administration.index'));
    }

    public function api_token(Request $request, User $user)
    {
        // проверка на существование токена
        if(!$request->has('generate') && !$request->has('regenerate')){

            $token_exist = $this->getUserToken($user);

            return response()->json(['tokenId'=>$token_exist->id ?? null], 200);
        }elseif($request->has('generate')){
            // создание токена
            $accessToken = $this->generateUserToken($user);

            return response()->json(['token'=>$accessToken ?? null], 200);
        }elseif($request->has('regenerate')){
            // Генерация нового токена
            $this->deleteUserToken($user);

            $accessToken = $this->generateUserToken($user);

            return response()->json(['token'=>$accessToken ?? null], 200);
        }
    }

    /**
     * Получение токена пользователя
     *
     * @param object $user
     * @return object|null
     */
    protected function getUserToken($user)
    {
        return \DB::table('oauth_access_tokens')
        ->where('user_id', $user->id)
        ->where('name','synchronize_api')
        ->first();
    }

    protected function deleteUserToken($user)
    {
        \DB::table('oauth_access_tokens')
        ->where('user_id', $user->id)
        ->where('name','synchronize_api')
        ->delete();
    }

    /**
     * Создание токена
     *
     * @param object $user
     * @return void
     */
    protected function generateUserToken($user)
    {
        $tokenResult = $user->createToken('synchronize_api');
        $accessToken = $tokenResult->accessToken;
        $token = $tokenResult->token;
        // обнуляем expires_at - для бессрочного токена (по умолчанию срок действия токена 1 год)
        $token->expires_at = null;
        $token->save();

        return $accessToken;
    }

}
