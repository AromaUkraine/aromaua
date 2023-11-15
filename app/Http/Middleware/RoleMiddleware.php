<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{

    public function handle($request, Closure $next, $roles, $permission = null)
    {
        $roles = explode("|", $roles);

        if(!\Auth::user()){
           return redirect()->route('login');
        }

        if(!$request->user()->hasRole($roles)) {
            abort(403);
        }

        if($permission !== null && !$request->user()->can($permission)) {
            abort(403);
        }  elseif (!$request->user()->can($request->route()->getName())) {
            abort(403);
        }

        return $next($request);
    }
}
