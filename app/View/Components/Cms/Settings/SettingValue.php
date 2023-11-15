<?php


namespace App\View\Components\Cms\Settings;


use App\View\Components\Cms\BaseCmsComponent;

class SettingValue extends BaseCmsComponent
{

    public function render()
    {

        if($this->model->component):
            return view('components.cms.settings.'.$this->model->component);
        endif;
    }

}
