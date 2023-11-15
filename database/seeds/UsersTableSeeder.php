<?php



use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         User::truncate();
        \DB::table('users_roles')->truncate();
        \DB::table('users_permissions')->truncate();

        $keys = (new Permission())->keys;

        $admin_keys = array_filter($keys, function ($item){
            return $item !== Role::DEVELOPER_ROLE;
        });

        $permissions = Permission::whereIn('type',$admin_keys)->get();

        $admin = [
            'login'=>env('ADMIN_NAME','admin'),
            'email'=>env('ADMIN_EMAIL','admin@admin.com'),
            'password'=>Hash::make('secret'),
            'email_verified_at'=>\Carbon\Carbon::now()
        ];
        $this->createUser($permissions, Role::ADMINISTRATION_ROLE, $admin);

        $permissions = Permission::all();

        $developer = [
            'login'=>'developer',
            'email'=>'developer@developer.com',
            'password'=>Hash::make('secret'),
            'email_verified_at'=>\Carbon\Carbon::now()
        ];
        $this->createUser($permissions, Role::DEVELOPER_ROLE, $developer);

    }


    protected function createUser($permissions, $role, $data)
    {
        $role = Role::where('slug',$role)->first();
        $user = User::create($data);
        $user->roles()->attach($role);
        $user->permissions()->attach($permissions);
    }

}
