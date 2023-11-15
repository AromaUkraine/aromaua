<?php

namespace App\Http\Middleware;

use Closure;

class CmsLocalizationMiddleware
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
        if (session()->has('cms_locale')) :
            \App::setLocale(session()->get('cms_locale'));
        else :
            \App::setLocale(config('app.cms_locale'));
        endif;

        return $next($request);
    }
}
