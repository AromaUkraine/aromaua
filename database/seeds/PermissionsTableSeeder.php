<?php

use App\Models\Role;
use App\Models\Permission;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;
use App\Helpers\PermissionHelper;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::truncate();

        $this->createPermissions();

    }


    protected function createPermissions()
    {
        $admin = Role::where('slug',Role::ADMINISTRATION_ROLE)->get();
        $developer = Role::where('slug', Role::DEVELOPER_ROLE)->get();

        $keys = (new Permission())->keys;

        $admin_keys = array_filter($keys, function ($item){
             return $item !== Role::DEVELOPER_ROLE;
        });

        $adminPermissions = app( PermissionService::class)->get($admin_keys);
        $developerPermissions = app( PermissionService::class)->get(Role::DEVELOPER_ROLE);

        foreach ($adminPermissions as $item) {

            $permission = $this->makePermissionData($item);

            if($permission) {
                $permission->roles()->attach($admin);
                $permission->roles()->attach($developer);
            }
        }

        foreach ($developerPermissions as $item) {

            $permission = $this->makePermissionData($item);

            if($permission) {
                $permission->roles()->attach($developer);
            }
        }
    }

    private function makePermissionData($data)
    {
        if (isset($data['as'])) {

            $as = explode('.', $data['as']);

            $perm['slug'] = $data['as'];
            $perm['type'] = array_shift($as);

            if (isset($data['controller'])) {

                $arr = explode('@', $data['controller']);
                $perm['controller'] = array_shift($arr);
                $perm['action'] = end($arr);
            }

            return Permission::create($perm);
        }
        return null;
    }
}
