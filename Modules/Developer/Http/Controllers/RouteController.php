<?php

namespace Modules\Developer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteController extends Controller
{

    public function index()
    {

        $keys =(new Permission())->keys;

        // protected from permissions route list
        $routes = collect( Route::getRoutes())->map( function ($route) use ($keys) {

            foreach ($keys as $key) {
                $name = $route->getName();

                if($name && str_is($key.'*', $name)) {

                    return [
                        'domain' => $route->domain(),
                        'method' => implode('|', $route->methods()),
                        'uri' => $route->uri(),
                        'name' => $name,
                        'action' => ltrim($route->getActionName(),'\\'),
                        'middleware' =>collect($route->gatherMiddleware())->implode(',')
                    ];
                }
            }
        })->filter(function ($value) { return !is_null($value); });

        return view('developer::route.index', compact('routes'));
    }
}
