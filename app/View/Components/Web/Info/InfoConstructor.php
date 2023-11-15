<?php

namespace App\View\Components\Web\Info;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;
use Modules\Information\Entities\Information;

class InfoConstructor extends WebComponents
{
    public $items = null;

    /**
     * Create a new component instance.
     *
     * @param $key
     * @param $page
     */
    public function __construct($key, $page)
    {
        if($page->componentActive($key)){
            $this->items = Information::active()
                ->published()
                ->where('parent_page_id', $page->id)
                ->with(['children'=>function($query){
                    $query->active()->published();
                }])
                ->get();
        }

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return null;
    }
}
