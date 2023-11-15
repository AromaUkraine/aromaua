<?php

namespace App\View\Components\Web\Gallery;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;
use Modules\Gallery\Entities\Gallery;

class GalleryPage extends WebComponents
{
    public $items;

    /**
     * Create a new component instance.
     *
     * @param $page
     * @param null $component
     */
    public function __construct($page, $component = null)
    {
      
        if ($page && $component) :
            $this->items = Gallery::where('parent_page_id', $page->id)
                ->where('page_component_id', $component->id)
                ->where('type', Gallery::TYPE_PHOTO)
                ->active()
                ->published()
                ->get();
        endif;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        // dump($this->items);
        return view('components.web.gallery.gallery-page');
    }
}