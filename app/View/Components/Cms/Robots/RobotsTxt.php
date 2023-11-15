<?php


namespace App\View\Components\Cms\Robots;


use App\Services\RobotsTxtService;
use App\View\Components\Cms\BaseCmsComponent;

class RobotsTxt extends BaseCmsComponent
{



    public function render()
    {
        $robots = app(  RobotsTxtService::class);

        if(!$robots->exist()) :
            $robots->make();
        endif;

        $this->value = $robots->get();

        return view('components.cms.robots.txt');
    }

}
