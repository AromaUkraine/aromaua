<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class DatePicker extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.fields.date-picker');
    }

    public function setDate()
    {

        $field = $this->name;

        if(!$this->model || !$this->model->$field )
        {
            if($this->value == 0){
                return null;
            }else{
                return date('d/m/Y', time());
            }

        }else{
            return $this->model->$field->format('d.m.Y') ;
        }
    }
}
