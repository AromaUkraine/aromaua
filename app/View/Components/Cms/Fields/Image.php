<?php

namespace App\View\Components\Cms\Fields;

use App\View\Components\Cms\BaseCmsComponent;


class Image extends BaseCmsComponent
{

    /**
     * @var int
     * 0 - all files
     * 1 - image
     * 2 - files
     * 3 - video
     */


    public $filemanager;
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->filemanager = config('app.filemanager', 'rfm');
        return view('components.cms.fields.image');
    }


    public function getSize()
    {
        if (isset($this->options['drop-zone-style'])) {
            return "style={$this->options['drop-zone-style']}";
        }
        return "style=width:100%;height:300px";
    }


    /**
     * @param $lang
     * @return false|string|null
     */
    public function setJsonValue($lang = null)
    {
        $value = $this->setValue($lang);

        if ($value) {
            return json_encode([$value]);
        }
        return null;
    }
}
