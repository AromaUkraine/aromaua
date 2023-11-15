<?php


namespace App\View\Components\Web\Banner;


use App\Services\PictureService;
use App\View\Components\Web\WebComponents;
use Illuminate\View\Component;
use Modules\Banner\Entities\Banner;

class BannerConstructor extends WebComponents
{
    public $items = null;

    public $page = null;

    public function __construct($key, $page)
    {

        $this->page = $page;

        if($page->componentActive($key)){

            $this->items = Banner::active()
                ->published()
                ->whereHas('component', function ($query) use($page,$key){
                    $query->where('alias', $key)->where('active', true);
                })
                ->where('parent_page_id', $page->id)
                ->get();

        }
    }

    public function render()
    {
        return null;
    }
}
