<?php

namespace App\View\Components\Cms\Nav;

use App\Models\EntityComponent;
use App\Models\Permission;
use Illuminate\View\Component;

/***
 * Навигация внутри записи
 * Class NavEntity
 * @package App\View\Components\Cms\Nav
 */
class NavEntity extends NavConstructor
{

    public $active = false;

    public function getActive($slug, $params=[])
    {

        $requestIs = request()->routeIs($slug);

        $action = \Str::beforeLast($slug,'.');

        $current = \Route::currentRouteName();
        $requestIn = \Str::is($action.'.*', $current);

        if($requestIs && $requestIn){
            return  'active';
        }

         return  '';
    }
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return parent::render();
    }
}
