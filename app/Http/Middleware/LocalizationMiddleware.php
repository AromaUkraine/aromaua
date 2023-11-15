<?php

namespace App\Http\Middleware;


use Closure;

class LocalizationMiddleware
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
        // текущий префикс языка
        $langPrefix = ltrim($request->route()->getPrefix(),'/');

        // массив доступных активный языков
        $locales = app()->languages->active()->slug();

        if($locales) {

            if((bool)$langPrefix && in_array($langPrefix, $locales)){
                \App::setLocale($langPrefix);
                session()->put('api_locale', $langPrefix);
            }else{
                \App::setLocale(config('app.fallback_locale'));
                session()->put('api_locale', config('app.fallback_locale'));
            }
        }

        return $next($request);
    }



}
