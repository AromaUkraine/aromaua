<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;

class Editor extends Textarea
{

    public $editor = 'ckeditor';


    public $filemanager;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        //'tinymce'
        // 'ckeditor'
        $this->editor = $this->options['editor'] ?? config('app.editor', 'tinymce');

        $this->filemanager = config('app.filemanager', 'rfm');

        return view('components.cms.fields.editor');
    }
}
