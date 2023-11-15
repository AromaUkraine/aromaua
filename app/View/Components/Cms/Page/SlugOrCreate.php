<?php


namespace App\View\Components\Cms\Page;


use App\Models\Page;
use App\View\Components\Cms\BaseCmsComponent;
use Modules\Developer\Entities\Template;

class SlugOrCreate extends BaseCmsComponent
{

    public function render()
    {
        return view('components.cms.page.slug-or-create');
    }

    public function getPages($lang)
    {
        return Page::withTypes()->actual($lang)->get();
    }

}
