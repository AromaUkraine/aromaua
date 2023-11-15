<?php


namespace App\Services;


use App\Models\Permission;
use App\Models\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class PermissionsRouteService
{
    private function permissions()
    {
        try {

            if (\Schema::hasTable('permissions')) {
                return Permission::where('data','!=',"")->get();
            }
            return null;
            //@todo заменить на prod
//            return Cache::remember(
//                'template_routes',
//                Carbon::now()->addWeek(),
//                function () {
//
//                    if (\Schema::hasTable('pages')) {
//                        $pages = Page::all();
//
//                        if ($pages->count()) {
//                            return $pages;
//                        }
//                    }
//
//                    return null;
//                }
//            );


        } catch (\Exception $e) {

        }

        return null;
    }


    public function routes()
    {
        $permissions = $this->permissions();

        if (!$permissions)
            return;

        $permissions->each(function (Permission $permission) {

            if(isset($permission->routes['method']) && $permission->routes['uri']) {

                $method = $permission->routes['method'];
                $uri = $permission->routes['uri'];
                $controller = $permission->routes['controller'];
                $action = $permission->routes['action'];
                // Удаляем тип доступа из slug он указан в группах роутов (section.) и т.д.
                $name = str_replace($permission->type.'.','', $permission->slug);

                Route::$method($uri,$controller.'@'.$action)->name($name);
            }

        });


       // $this->checkRoutes();
    }

    private function checkRoutes()
    {
        $routes = Route::getRoutes()->get();

        foreach ($routes as $route) {

            if ($route->action['prefix'] === 'cms/'
                || $route->action['prefix'] === 'cms'
                || $route->action['prefix'] === '/cms'
            ) {
                dump($route->action);
            }
        }
        dd();
    }
}
