<?php

namespace App\View\Components\Cms\Nav;
use App\Models\Permission;

class NavPage extends NavConstructor
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return parent::render();
    }

    /**
     * подсветка активной вкладки
     * @param $slug
     * @param $params
     * @return string
     */
    public function getActive($slug, $params=[])
    {
        $route = route($slug, $params);

        $action = \Str::beforeLast($slug,'.');
        $current = \Route::currentRouteName();

        // первый вариант
        if(\Str::endsWith($route, request()->path())){
            return 'active';
        }

        // второй, если первый не сработал
        if(str_is($route.'*', request()->url())){
            return 'active';
        }

//        $is = str_is($route.'*', request()->url());
//        $in = \Str::is($action.'.*', $current);
//
//        $active = false;
//        if($is && $in){
//            return 'active';
//        }
//
//        if(!$active && ($is || $in)){
//            return 'active';
//        }
    }




}
