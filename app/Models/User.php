<?php

namespace App\Models;


use App\Traits\PermissionTrait;
use App\Traits\QueryTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{

    use Notifiable, SoftDeletes, PermissionTrait, Cachable;

    // Трейт api
    use HasApiTokens;

    use QueryTrait;
    /**
     * Атрибуты, которые должны быть преобразованы в даты.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login',  'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Получение первой роли
     * @return mixed
     */
    public function getRoleAttribute()
    {
        return $this->roles->first();
    }

    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    public function phones()
    {
        return $this->hasMany(UserPhone::class);
    }

}
