<?php

namespace App\View\Components\Cms\FileManager;


class ImageGallery extends FileManagerConstruct
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->params .= "&field_id=dz-gallery&multiple=1&callback=fm_callback";

        return view('components.cms.file-manager.image-gallery');
    }
}
