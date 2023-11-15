<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{

    use Cachable;

    const ADMINISTRATION_ROLE = 'admin';
    const DEVELOPER_ROLE = 'developer';
    const MANAGER_ROLE = 'manager';
    const API_ROLE = 'api';
    const DEFAULT_ROLE = 'guest';

    protected $fillable = ["name",'slug',"description"];

    public $all_roles = [ self::ADMINISTRATION_ROLE,  self::MANAGER_ROLE, self::DEVELOPER_ROLE, self::DEFAULT_ROLE, self::API_ROLE];

    public $administration_roles = [ self::ADMINISTRATION_ROLE,  self::MANAGER_ROLE, self::DEVELOPER_ROLE, self::API_ROLE ];

    public function scopeAdministration($query)
    {
        return $query->whereIn('slug', $this->administration_roles);
    }

    public function notCreatedAdministrationRoles()
    {
        $all = self::administration()->get();

        return collect( $this->administration_roles)->filter(function ($slug) use ($all){
            return !$all->contains('slug', $slug);
        });
    }

    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function permissions() {

        return $this->belongsToMany(Permission::class,'roles_permissions');
    }

    public function users() {
        return $this->belongsToMany(User::class,'users_roles');
    }


}
