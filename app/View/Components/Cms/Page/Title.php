<?php

namespace App\View\Components\Cms\Page;

use App\Helpers\TemplateHelper;
use Illuminate\View\Component;

class Title extends Breadcrumbs
{

    public $pageTitle = '';

    private $delimiter = ' - ';
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $this->makeTitle();

        return view('components.cms.page.title');
    }



    private function makeTitle()
    {
        $this->pageTitle .= $this->getDefaultTitleInConfig();

        if($this->pageTitle && $this->breadcrumbs->count()) :
            $this->pageTitle .= $this->delimiter;
        endif;

        foreach ($this->breadcrumbs as $item) {

            if(!is_array($item)){
                $this->pageTitle .= __($item['name']).$this->delimiter ?? '';
            }
        }
        $this->pageTitle = \Str::beforeLast($this->pageTitle,$this->delimiter);
    }

    private function getDefaultTitleInConfig()
    {
        $configData = TemplateHelper::all();


        return $configData['templateTitle'] ?? '';
    }
}
