<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::truncate();
        DB::table('roles_permissions')->truncate();

        $this->createRole(Role::ADMINISTRATION_ROLE, 'Administrator');
        $this->createRole(Role::DEVELOPER_ROLE, 'Developer');
        $this->createRole(Role::DEFAULT_ROLE, 'Guest');

    }

    protected function createRole($slug, $name)
    {
        $role = new Role();
        $role->slug = $slug;
        $role->name = $name;
        $role->save();
    }
}
