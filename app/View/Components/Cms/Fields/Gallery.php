<?php


namespace App\View\Components\Cms\Fields;


use App\View\Components\Cms\BaseCmsComponent;

class Gallery extends Image
{

    /**
     * @var int
     * 0 - all files
     * 1 - image
     * 2 - files
     * 3 - video
     */

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->filemanager = config('app.filemanager', 'rfm');
        return view('components.cms.fields.gallery');
    }
}
