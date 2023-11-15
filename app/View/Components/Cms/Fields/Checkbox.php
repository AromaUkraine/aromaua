<?php

namespace App\View\Components\Cms\Fields;



use App\View\Components\Cms\BaseCmsComponent;

class Checkbox extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.fields.checkbox');
    }

    public function getName()
    {
        if(isset($this->options['group'])){
            return $this->options['group']."[".$this->name."]";
        }else{
            return $this->name;
        }
    }

    public function getId($lang=false)
    {
        $this->id = str_replace('.',"_", $this->name);
        if(isset($this->options['group'])){
            return $this->options['group']."_".$this->id;
        }
        return $this->id;
    }
}
