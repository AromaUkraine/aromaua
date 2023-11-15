<?php

namespace App\View\Components\Cms\DragAndDrop;

use App\View\Components\Cms\BaseCmsComponent;
use Illuminate\View\Component;

class DaDLeftRight extends BaseCmsComponent
{

    public $fixed = false;

    public function render()
    {
        return view('components.cms.drag-and-drop.left-right');
    }

    public function isFixed($item)
    {
        if(isset($this->options['fixed']) && $this->options['fixed']) :
            foreach ($this->options['fixed'] as $key=>$value)
            {
                if(isset($item[$key]) && $item[$key] == $value)
                   return  true;
            }
        endif;

       return false;
    }

}
