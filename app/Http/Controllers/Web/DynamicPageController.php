<?php


namespace App\Http\Controllers\Web;


use App\Models\Page;
use Illuminate\Routing\Controller as BaseController;

class DynamicPageController extends BaseController
{
    // Show a page by slug
    public function show($slug = 'main')
    {
        $page = Page::active()->joinTranslation(true, $slug)->first();

        if (!$page)
            abort(404);

        $action = $page->action;
        return  app($page->controller)->$action($page);
    }
    // Show a product by category / slug
    public function product($category_slug, $product_slug)
    {
        $category = Page::active()->joinTranslation(true, $category_slug)->first();
        $product = Page::active()->joinTranslation(true, $product_slug)->first();

        if (!$product || !$category)
            abort(404);

        $action = $product->action;
        return  app($product->controller)->$action($product, $category->pageable->id);
    }
}
