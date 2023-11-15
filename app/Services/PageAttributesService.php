<?php


namespace App\Services;


use App\Models\Page;

class PageAttributesService
{

    /**
     *  Обьединяем данные из PublishAttribute c данными из Page
     * @param Page $page
     * @param $action
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function concat(Page $page, $action)
    {
        $data = app(PublishAttribute::class)->make();

        $data['method'] = $page->method;
        $data['controller'] = $page->controller;
        $data['action'] = $action;

        return $data;
    }
}
