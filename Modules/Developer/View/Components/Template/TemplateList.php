<?php

namespace Modules\Developer\View\Components\Template;

use App\View\Components\Cms\BaseCmsComponent;
use Modules\Developer\Entities\Template;

class TemplateList extends BaseCmsComponent
{
    public $templates;

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {

        $this->templates = Template::all();//where('is_main', false)->get();

        return view('developer::components.template.template-list');
    }
}
