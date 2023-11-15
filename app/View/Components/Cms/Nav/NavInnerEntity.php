<?php


namespace App\View\Components\Cms\Nav;


class NavInnerEntity extends NavConstructor
{
    public $active;

    public function getActive($slug, $params = [], $key = null)
    {
        $action = \Str::beforeLast($slug, '.');
        $current = \Route::currentRouteName();

        return (\Str::is($action . '.*', $current)) ? 'active' : '';
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
