<?php


namespace App\Traits;


use App\Models\Permission;
use App\Models\Role;

trait PermissionTrait
{
    /**
     * Назначение пользователю права доступа
     * @param $permissions
     * @return $this
     */
    public function givePermissionsTo( $permissions ) {

        $permissions = $this->getPermissions($permissions);
        $this->permissions()->attach($permissions);

        return $this;
    }

    /**
     *  Удаление у пользователя отдельных прав доступа
     * @param mixed ...$permissions
     * @return $this
     */
    public function withdrawPermissionsTo( ...$permissions ) {

        $permissions = $this->getPermissions($permissions);
        $this->permissions()->detach($permissions);
        return $this;
    }


    /**
     *  Сброс все прав доступа пользователя
     */
    public function resetPermissions() {
        $this->permissions()->detach();
    }



    /**
     * Сброс все прав доступа пользователя и установка новых
     *
     * @param mixed $permissions
     * @return PermissionTrait
     */
    public function refreshPermissions( $permissions ) {

        $this->resetPermissions();
        return $this->givePermissionsTo($permissions);
    }



    public function hasPermissionTo($permission) {

        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }



    public function hasPermissionThroughRole($permission) {

        foreach ($permission->roles as $role){
            if($this->roles->contains($role)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole( $roles ) {

        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }


    public function roles() {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function role() {
        return $this->belongsToMany(Role::class,'users_roles')->first();
    }


    public  function hasPerm( ...$permissions)
    {
        foreach ($permissions as $permission) {
            if ($this->permissions->contains('slug', $permission)) {
                return true;
            }
        }
        return false;
    }


    public function hasPermission($permission) {

        return (bool) $this->permissions->where('slug', $permission->slug)->count();
    }


    public function permissions() {

        return $this->belongsToMany(Permission::class,'users_permissions');
    }


    protected function getPermissions($permissions) {

        return Permission::whereIn('slug',$permissions)->get();
    }

    public function getAllPermissions()
    {
        return $this->select(['permissions.id as permission_id', 'permissions.slug'])
            ->join('users_permissions','users.id','=','users_permissions.user_id')
            ->join('permissions','users_permissions.permission_id',"=","permissions.id")
            ->where('users.id', $this->id)
            ->get();
    }


    /**
     *  Сброс все ролей пользователя
    public function resetRoles() {
        $this->roles()->detach();
    }  */
}