<?php

namespace App\Http\Middleware;

use Closure;

class CKFinderAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::user()){
            config(['ckfinder.authentication' => function() {
                return true;
            }]);
        }

        return $next($request);
    }
}
