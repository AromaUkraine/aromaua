<?php

namespace App\View\Components\Cms\FileManager;


class FileManager extends FileManagerConstruct
{

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->params .= "&multiple=1&callback=fm_callback&type=2";

        return view("components.cms.file-manager.{$this->filemanager}-file-manager");
    }
}
