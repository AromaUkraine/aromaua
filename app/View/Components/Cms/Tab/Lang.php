<?php

namespace App\View\Components\Cms\Tab;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class Lang extends BaseCmsComponent
{
    public $languages = [];
    public $default_language;

    /**
     * @var object|null
     */
    public $model;



    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // принудительно устанавливаем коллекцию языков
        $this->setLanguages(true);

//        $this->default_language = config('app.fallback_locale');


        return view('components.cms.tab.lang');
    }
}
