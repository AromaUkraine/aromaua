<?php


namespace App\Services;


use App\Events\ResetCachePagesRouteEvent;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Modules\Developer\Entities\Template;

class PermissionService
{


    /**
     * Возвращает массив защищенных роутов по переданному ключу
     *
     * @param $key
     * @return array
     */
    private function getProtectedUrls($key)
    {
        $result = [];

        // очищаем кеш роутов
        event(new ResetCachePagesRouteEvent());

        $routeCollection = Route::getRoutes()->get();
        foreach ($routeCollection as $route) {
            $action = $route->getAction();

            if (array_key_exists('as', $action)) {

                if (str_is($key . '.*', $action['as'])) {

                    $result[] = $action;
                }
            }
        }
        return $result;
    }

    /**
     * Возвращает массив доступов по ключу (ключам) (помеченого в роутах как as)
     *
     * @param $keys
     * @return array
     */
    public function get($keys)
    {
        if (is_array($keys)) {
            $data = [];
            foreach ($keys as $key) {
                $data = array_merge($data, $this->getProtectedUrls($key));
            }
            return $data;
        } else {
            return $this->getProtectedUrls($keys);
        }
    }



    /**
     * Присвоение доступов по ролям и пользователям
     * @param $permission
     */
    public function assignment($permission)
    {
        if ($permission) {

            $adminRole = Role::where('slug', Role::ADMINISTRATION_ROLE)->get();
            $developerRole = Role::where('slug', Role::DEVELOPER_ROLE)->get();
            $admins = User::whereHas(
                'roles',
                function ($query) {
                    $query->where('slug', Role::ADMINISTRATION_ROLE);
                }
            )->get();
            $developers = User::whereHas(
                'roles',
                function ($query) {
                    $query->where('slug', Role::DEVELOPER_ROLE);
                }
            )->get();

            $permission->roles()->attach($adminRole);
            $permission->roles()->attach($developerRole);

            foreach ($admins as $user) {
                $user->permissions()->attach($permission);
            }
            foreach ($developers as $user) {
                $user->permissions()->attach($permission);
            }
        }
    }




    public function makeByEvent($event, $routes)
    {
        foreach ($routes as $route) {

            foreach ($route as $item) {
                return $this->setData($event, $item);
            }
        }
    }

    public function setData($event, $item)
    {

        foreach ($event->locales as $locale) {

            if ($event->page->translate($locale)) {

                $item = $this->modify($event, $item, $locale);

                return [
                    'data' => [
                        'template_id' => $event->pageable->id,
                        'page_id' => $event->page->id,
                        'routes' => $item
                    ],
                    'type' => $item['type'],
                    'slug' => $item['slug'],
                    'controller' => Template::RESOURCE_CMS_CONTROLLERS_PATH . $item['controller'],
                    'action' => $item['action']
                ];
            }
        }

        return null;
    }


    private function modify($event, $item, $locale)
    {

        $slug = $event->page->translate($locale)->slug;
        $slug = \Str::lower($slug);
        $slug = preg_replace(array('/\W/', '/ /'), array('', '_'), $slug);

        $item['uri'] = str_replace('{name}', $slug, $item['uri']);
        $item['slug'] = $item['type'] . '.' . $slug . '.' . $item['action'];

        return $item;
    }


    public function getPermissionByPage($page)
    {
        return Permission::pageSlug($page);
    }


    public function createPermissionByData($data)
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