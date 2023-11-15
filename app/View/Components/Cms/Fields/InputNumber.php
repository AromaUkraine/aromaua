<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;

class InputNumber extends BaseCmsComponent
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.cms.fields.input-number');
    }


    public function setParams($params = [])
    {
        $data = '';
        foreach ($params as $param) {
            if(isset($this->options[$param])) :
                $data .= ' data-bts-'.$param.'='.$this->options[$param].' ';
            endif;
        }

        return $data;
    }
}
