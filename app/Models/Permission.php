<?php

namespace App\Models;


use App\Traits\JsonDataTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use JsonDataTrait;

    use Cachable;

    // Ключи в route->as();
    // По этим ключам ищутся защищенные доступы, обновляюся правила доступов, обновляются пункты меню в админке
    public $keys = ['root', 'admin', 'developer', 'section', 'module', 'catalog'];

    protected $guarded = [];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_permissions');
    }

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }


    public static function pageSlug($page, $action='index'){

        $permission = Permission::withCondition($page->pageable->id, $page->id)
            ->action($action)->first();

        if($permission)
            return $permission->slug;

        return null;
    }

    /**
     * @param $query
     * @param $template_id
     * @param $page_id
     * @return mixed
     */
    public function scopeWithCondition($query, $template_id, $page_id)
    {
        return $query->where('data->template_id', $template_id)
            ->where('data->page_id', $page_id);
    }

    /**
     * @param $query
     * @param $action
     * @return mixed
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }
}
