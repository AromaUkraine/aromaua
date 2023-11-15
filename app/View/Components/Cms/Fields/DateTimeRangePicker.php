<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;
use Carbon\Carbon;

class DateTimeRangePicker extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.fields.date-time-range-picker');
    }

    public function setId($lang = false)
    {
        return parent::setId($lang) ?? 'datetimerangepicker';
    }

    public function setDate($key)
    {
        if(isset($this->options[$key])):
            $name = $this->options[$key];

            if($this->model && isset($this->model->$name)):
               return $this->model->$name;
            endif;

        endif;

        return 0;
    }
}
