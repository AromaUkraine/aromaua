<?php


namespace App\Http\Controllers\Web;


use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\Product;
use Modules\Gallery\Entities\Gallery;
use Modules\Catalog\Entities\ProductCategory;

class ProductController extends Controller
{
    public function index($page, $categoryId = null)
    {
        // текущая категория с наследниками и предками
        if (!$categoryId) {
            $categoryId = $page->pageable->category->id;
        }

        $category = ProductCategory::where('product_categories.id', $categoryId)
            ->joinPage(true, true, null, [app()->getLocale(), 'ru', 'en', config('app.fallback_locale')])
            ->with(['children' => function ($query) {
                $query->joinPage(true, true, null, [app()->getLocale(), 'ru', 'en', config('app.fallback_locale')]);
            }])
            ->with(['ancestors' => function ($query) {
                $query->joinPage(true, true, null, app()->getLocale());
            }])
            ->first();


        $product = Product::where('products.id', $page->pageable->id)
            ->joinPage(true, true)
            ->with([
                'documents' => function($query) {
                    $query->orderBy('serial_number','asc');
                    $query->translated();
                },
                'columns'=>function($query) use ($categoryId){
                    $query->where('product_product_category_prices.product_category_id', $categoryId)
                        ->orderBy('column_number','asc')
                        ->withTranslation();
                },
                'gallery'=>function($query){
                    $query->active()->published();
                }
            ])
            ->firstOrFail();


        // родительский шаблон (Каталог)
        $root = (new ProductCategory())->getRootPage($page->pageable->category->page);

        return view('web.catalog.product', compact('page', 'product', 'root', 'category'));

    }
}
