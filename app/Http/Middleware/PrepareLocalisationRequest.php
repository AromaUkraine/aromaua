<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PrepareLocalisationRequest
{
    /**
     * Handle an incoming request.
     * Удаляем из Request пустые массивы языков, которые не выбраны и не должны валидироваться!
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // except default
        $languages = app()->languages->all()->get();


        foreach($languages as $lang) {

            if($lang->short_code !== config('app.locale')){
                // Если небыло включено ни одного языка - оставляем только язык по умолчанию,
                // иначе удаляем не добавленные к валидации языки
                if(!isset($request->enable)) {

                    $request->offsetUnset($lang->short_code);
                }else {

                    if(!key_exists($lang->short_code, $request->enable)){
                        $request->offsetUnset($lang->short_code);
                    }
                }
            }
        }

        return $next($request);
    }
}
