<?php


namespace Modules\Catalog\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Catalog\Service\SeoCatalogRedirectService;

/**
 * Посредник для редиректа на сео-страницу
 * Class SeoCatalogMiddleware
 * @package Modules\Catalog\Http\Middleware
 */
class SeoCatalogMiddleware
{


    public function handle(Request $request, Closure $next)
    {
       /* $redirect = null;

        $redirect = app(SeoCatalogRedirectService::class)->getRedirectSlug( $request );

        if($redirect):
            return redirect(url($redirect));
        endif;*/

        return $next($request);
    }
}
