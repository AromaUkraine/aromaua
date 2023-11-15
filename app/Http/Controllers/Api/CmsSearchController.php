<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Permission;
use Nwidart\Modules\Facades\Module;
use Auth;
use Modules\Article\Entities\Article;
use Modules\Article\Entities\ArticleCategory;
use Modules\Catalog\Entities\Feature;
use Modules\Catalog\Entities\Product;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;

class CmsSearchController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {

            $result = collect();

            // поиск элементов меню
            $menu = $this->searchOnMenu($request->search);
            // поиск динамически созданных страниц
            $pages = $this->searchOnPages($request->search);
            // поиск категорий товаров, товаров, сео-страниц
            $catalog = $this->searchOnCatalog($request->search);
            // поиск категорий статей и статей
            $articles = $this->searchOnArticles($request->search);


            $result = $result->merge($menu ?: collect())
                ->merge($pages ?: collect())
                ->merge($catalog ?: collect())
                ->merge($articles ?: collect());

            return response()->json(['result' => $result]);
        }
    }



    /**
     * Поиск по меню
     *
     * @param string $str
     * @return null/Illuminate/Support/Collection
     */
    protected function searchOnMenu($str)
    {
        return Permission::join('menus', function ($join) {
            $join->on('permissions.id', '=', 'menus.permission_id');

            $join->join('menu_translations', function ($join) {
                $join->on('menus.id', '=', 'menu_translations.menu_id');
            });
        })
            ->select(
                'permissions.id as perm_id',
                'permissions.*',
                'menus.id as menu_id',
                'menus.*',
                'menu_translations.id as mt_id',
                'menu_translations.*'
            )
            ->where('menus.deleted_at', null)
            ->where('permissions.action', 'index')
            ->where('permissions.data', '=', '')
            ->where('menu_translations.name', 'like', '%' . $str . '%')
            ->groupBy('permissions.id')
            ->get()->map(function ($item) {
                if (Auth::user()->can($item->slug)) {
                    return [
                        'name' => $item->name,
                        'route' => route($item->slug),
                        'icon' => $item->icon
                    ];
                }
            });
    }


    /**
     * Поиск по динамическим страницам
     *
     * @param string $str
     * @return null/Illuminate/Support/Collection
     */
    protected function searchOnPages($str)
    {
        return Permission::join('pages', function ($join) {
            $join->on('permissions.data->page_id', '=', 'pages.id');

            $join->join('page_translations', function ($join) {
                $join->on('pages.id', '=', 'page_translations.page_id');
            });
        })
            ->select(
                'permissions.id as perm_id',
                'permissions.slug as permission_slug',
                'permissions.*',
                'pages.id as page_id',
                'pages.*',
                'page_translations.id as pt_id',
                'page_translations.*'
            )
            ->where('pages.deleted_at', null)
            ->where('permissions.action', 'index')
            ->where('permissions.data', '!=', '')
            ->where('page_translations.name', 'like', '%' . $str . '%')
            ->groupBy('page_translations.page_id')
            ->get()->map(function ($item) {
                if (Auth::user()->can($item->permission_slug)) {
                    return [
                        'name' => $item->name,
                        'route' => route($item->permission_slug, $item->page_id, $item->slug),
                        'icon' => $item->icon
                    ];
                }
            });
    }

    /**
     * Поиск категории товаров, товары, сео-страницы, харак-ки
     *
     * @param string $permission_slug
     * @param string $model
     * @param string $str
     * @return null/Illuminate/Support/Collection
     */
    protected function searchOnCatalog($str)
    {
        // если есть модуль каталог
        if (Module::find('Catalog')) {

            $permission_model_collection = collect([
                [
                    'slug' => 'catalog.product_category.edit',
                    'model' => ProductCategory::class,
                    'title' => __('cms.product_category')
                ],
                [
                    'slug' => 'catalog.product.edit',
                    'model' => Product::class,
                    'title' => trans_choice('cms.Product', 1)
                ],
                [
                    'slug' => 'catalog.seo_catalog.edit',
                    'model' => SeoCatalog::class,
                    'title' => trans_choice('cms.seo_page', 1)
                ],
            ]);

            return Page::whereTranslationLike('name', '%' . $str . '%')
                ->where('pages.deleted_at', null)
                ->whereIn('pages.pageable_type', $permission_model_collection->pluck('model'))
                ->get()
                ->map(function ($item) use ($permission_model_collection) {
                    $permission = $permission_model_collection->where('model', $item->pageable_type)->first(); //['permission_slug'];
                    return [
                        'name' => $item->name . "<span class='small ml-1 lowercase'><b>" . $permission['title'] . "</b></span> ",
                        'route' => route($permission['slug'], $item->pageable_id),
                        'icon' => $item->icon
                    ];
                });
        }
        return null;
    }


    protected function searchOnArticles($str)
    {

        if (Module::find('Article')) {


            $permission_model_collection = collect([
                [
                    'slug' => 'module.article_category.edit',
                    'model' => ArticleCategory::class,
                    'title' => __('cms.article.categories')
                ],
                [
                    'slug' => 'module.article.edit',
                    'model' => Article::class,
                    'title' => __('cms.articles')
                ]
            ]);


            return Page::whereTranslationLike('name', '%' . $str . '%')
                ->with('pageable')
                ->where('pages.deleted_at', null)
                ->whereIn('pages.pageable_type', $permission_model_collection->pluck('model'))
                ->get()
                ->map(function ($item) use ($permission_model_collection) {
                    $permission = $permission_model_collection->where('model', $item->pageable_type)->first(); //['permission_slug'];

                    return [
                        'name' => $item->name . "<span class='small ml-1 lowercase'><b>" . $permission['title'] . "</b></span> ",
                        'route' => route($permission['slug'], [$item->pageable->parent_page_id, $item->pageable_id]),
                        'icon' => $item->icon
                    ];
                });
        }
    }
}