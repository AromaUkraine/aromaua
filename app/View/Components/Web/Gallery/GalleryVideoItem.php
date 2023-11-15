<?php

namespace App\View\Components\Web\Gallery;

use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;

class GalleryVideoItem extends WebComponents
{

    public $link;

    public $image;

    public $alt;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($link, $image, $alt='')
    {

        $name = \Str::afterLast($link, '/');
        $youtube_path = 'http://www.youtube.com/watch?v=';

        $this->link = $youtube_path.$name;///'http://www.youtube.com/embed/M7lc1UVf-VE?autoplay=1';//$youtube_path.$name.'&autoplay=1&rel=0';
        $this->image = $image;
        $this->alt = $alt;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.web.gallery.gallery-video-item');
    }
}
