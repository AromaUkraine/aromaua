<?php


namespace  Modules\Synchronize\Traits;

use Modules\Synchronize\Service\ClearDataService;
use Modules\Synchronize\Service\TranslationService;

trait SyncCategoriesTrait
{
    public function createOrUpdatePageCategory($event, $category, $item, $name="title")
    {

        $page_data = ['active'=>true];
        $routes = config('catalog.routes.product_category.web.view',[]);

        $page_data = array_merge($page_data, $routes);

        $name = strip_tags($item->$name);

        // slug from root categories
        if(isset($item->uml) && isset($item->link)){

            $slug = $item->uml ?? $item->link;


            if(!strlen($slug))
                $slug = \Transliterate::slugify($name);

        }else{

            $slug = \Transliterate::slugify($name);
        }

        $translate_data = [
            'name'=>$name,
            'slug'=> $slug,
            'publish'=>!$item->NotVisibleShop ?? false
        ];


        $page_data = app( TranslationService::class)->make($page_data, $translate_data);


        if(!$category->page) {
            $category->page()->create($page_data);
        }else{
            $category->page->update($page_data);
        }
    }
}
