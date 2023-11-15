<?php

namespace App\View\Components\Cms\Advanced;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class Filter extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->changeOptions();

        return view('components.cms.advanced.filter');
    }

    private function changeOptions()
    {
        if(!isset($this->options['method'])):
            $this->options['method'] = 'GET';
            $this->options['class'] = 'form-filter';
        endif;
    }
}
