<?php

namespace App\Http\Controllers\Web;

use App\Helpers\CollectionHelper;
use App\Http\Controllers\Controller;
use Modules\Catalog\Entities\ProductCategory;

class ProductCategoryController extends Controller
{
    public function view($page)
    {

        // родительский шаблон (Каталог)
        $root = (new ProductCategory())->getRootPage($page);

        // текущая категория с наследниками и предками
        $category = ProductCategory::where('product_categories.id', $page->pageable->id)
            ->joinPage()
            ->with(['children' => function ($query) {
                $query->joinPage()->withGallery();
            }])
            ->with(['ancestors' => function ($query) {
                $query->joinPage();
            }])
            ->first();


        if ($category->children->count()){
            // добавляем пагинацию к коллекции
            $categories = CollectionHelper::paginate($category->children, 20);

            return view('web.catalog.index', compact('page', 'root', 'category', 'categories'));
        }

        // dump($category->data);

        return view('web.catalog.view', compact('page', 'root', 'category'));

    }
}
