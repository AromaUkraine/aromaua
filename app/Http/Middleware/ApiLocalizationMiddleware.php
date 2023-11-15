<?php

namespace App\Http\Middleware;

use Closure;

class ApiLocalizationMiddleware
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
        if(session()->has('api_locale')):
            \App::setLocale(session()->get('api_locale'));
        else:
            \App::setLocale(config('app.fallback_locale'));
        endif;

        return $next($request);
    }
}
