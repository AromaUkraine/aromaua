<?php

namespace App\View\Components\Cms\Pills;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class PillVertical extends BaseCmsComponent
{
    /**
     * @var array
     */
    public $items;



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->items = $this->options['items'];

        return view('components.cms.pills.pill-vertical');
    }


    public function getRoute($data)
    {

        return route($data['slug'], $data['page']['id']);
//        dump($data['page']['id']);
//        return "#";
    }
}
