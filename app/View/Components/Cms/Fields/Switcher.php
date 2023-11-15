<?php

namespace App\View\Components\Cms\Fields;


use App\View\Components\Cms\BaseCmsComponent;

class Switcher extends  BaseCmsComponent
{

    public function render()
    {
        return view('components.cms.fields.switcher');
    }

    public function setChecked($lang = null)
    {
        $name = $this->name;

        if($this->value)
            return 'checked';


        if(!$lang){

            if($this->model) {
                if($this->model->$name)
                    return 'checked';
            }else{
                if(old($name))
                    return 'checked';
            }
        }
        return null;
    }

}
