<?php


namespace Modules\Catalog\Service;


use Illuminate\Http\Request;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;

class SeoCatalogRedirectService
{

    private $uri;
    /**
     * @var null
     */
    protected $reset_filter;

    protected $feature;

    protected $query_string;

    private $query;
    private $langPrefix;

    public function __construct(Request $request)
    {
        $this->removeLocaleFromUri($request);
    }

    public function getRedirectSlug(Request $request)
    {
        $redirectTo = null;
        $this->feature = $request->feature ?? null;
        $this->reset_filter = $request->reset_filter ?? null;
        $this->query_string = $this->removeQueryParams(['feature', 'reset_filter']);

        // это страница категории товаров
        if ($is_category_product_page = $this->getCategoryProductPage()) :
            return $this->findRedirectFromProductCategoryPage($is_category_product_page);
        endif;

        // это сео-страница
        if ($is_seo_page = $this->getSeoPage()) :

            // сео-страница без категории
            if ($is_seo_page && !$is_seo_page->product_category_id) :
                $result = $this->findRedirectFromSeoCatalogWithoutCategoryPage($is_seo_page);
                if($result) :
                    return $result;
                else:
                    // нужно удалить хар-ку отвечающую за эту сео-страницу из GET-параметров
                     return $this->removeQueryParamsByCurrentSeoPage($is_seo_page);
                endif;

            endif;

            // выключен фильтр - перенаправляем на категорию
            if ($is_seo_page && $is_seo_page->product_category_id && $this->reset_filter && !$this->feature) :
                $result = $this->redirectToPreventCategoryProductPage($is_seo_page);
                $result = $this->removeQueryParams(['reset_filter'], $result);
                return $this->addLocalePrefixToUri($result);
            endif;

            // была сео-страница и появились новые хар-ки
            if ($is_seo_page && $this->feature):
                return $this->findRedirectFromSeoCatalogPage($is_seo_page);
            endif;

        endif;

    }


    private function findRedirectFromProductCategoryPage($product_category): ?string
    {
        $result = null;

        $seo_pages = $this->findSeoPageWithProductCategoryNotBrand($product_category->id);

        if ($seo_pages->count()) :
            $result = $this->findExactMatchSeoPageSlug($seo_pages);
        else:
            // ищем сео-страницу не связанную с категорией
            $seo_pages = $this->findSeoPageWithoutProductCategoryNotBrand();

            if ($seo_pages->count()) :
                $result = $this->findExactMatchSeoPageSlug($seo_pages);
            endif;

        endif;

        // берем slug страницы, поскольку это переход от страницы категории на страницу сео-каталога, параметры в запросе не используем
        if ($result) :
            $result = $this->makeRedirectUri($result);
            $result = $this->addLocalePrefixToUri($result);
        endif;

        return $result;
    }


    private function findRedirectFromSeoCatalogWithoutCategoryPage($seo_page)
    {
        $result = null;
        //проверка чтобы небыло бесконечного редиректа
        if($this->feature) :

            $seo_pages = $this->findSeoPageWithoutProductCategoryNotBrand();
            if ($seo_pages->count()) :

                $seo_page->entity_features->each(function ($ef){
                    $this->feature[$ef->feature_id][] = $ef->feature_value_id;
                });

                $result = $this->findExactMatchSeoPageSlug($seo_pages);
                // берем slug страницы, поскольку это переход от страницы категории на страницу сео-каталога, параметры в запросе не используем
                if ($result) :
                    $result = $this->makeRedirectUri($result);
                    $result = $this->addLocalePrefixToUri($result);
                endif;

            endif;

        endif;

       return $result;
    }

    private function findRedirectFromSeoCatalogPage($seo_page): ?string
    {
        $result = null;
        $seo_pages = $this->findSeoPageWithProductCategoryNotBrand($seo_page->product_category_id);

        if ($seo_pages->count()) :
            $result = $this->findExactMatchSeoPageSlug($seo_pages);
        endif;

        if (!$result):

            $url = $seo_page->category->page->slug;

            $url .= '?' . http_build_query(request()->query());
            $url = $this->addLocalePrefixToUri($url);

            return $url;
        else:
            // берем slug страницы, поскольку это переход от страницы категории на страницу сео-каталога, параметры в запросе не используем
            $result = $this->makeRedirectUri($result);
            return $this->addLocalePrefixToUri($result);
        endif;
    }


    /**
     *  Возвращает url + дополнительные пар-ры фильтра (сортировка, пагинация и т.д.)
     * @param $data
     * @param false $add_query
     * @return string
     */
    public function makeRedirectUri($data, $add_query = false): string
    {
        if (!$add_query) :
            return $data->slug;
        else:
            $referer_query = parse_url($this->query_string, PHP_URL_QUERY);
            parse_str($referer_query, $params);
            return $data->slug . '?' . http_build_query($params);
        endif;
    }


    /**
     *  Возврат на страницу категории  + добавляем все хар-ки из фильтра (если есть таковые)
     * @param $seo_page
     * @return string
     */
    private function redirectToPreventCategoryProductPage($seo_page): string
    {
        $url = $seo_page->category->page->slug;
        $url .= '?' . http_build_query(request()->query());
        return $url;
    }


    /**
     * Ищет точное совпадение с сео-страницей
     * @param $seo_pages
     * @return null
     */
    private function findExactMatchSeoPageSlug($seo_pages)
    {

        $diff = false;
        $result = null;

        if ($this->feature) :

            $seo_pages->filter(function ($seo) {
                $features = array_keys($this->feature);
                $feature_ids = $seo->entity_features->pluck('feature_id');
                // если количество переданных хар-тик совпадает с кол-вом хар-тик
                // найденой сое-страницы и они не отличаются
                return (count($features) == $feature_ids->count() && !$feature_ids->diff($features)->count());

            })->map(function ($seo) use (&$result, &$diff) {

                $seo->entity_features
                    ->groupBy('feature_id')
                    ->map(function ($group, $index) use ($seo, &$result, &$diff) {

                        $values = array_values($this->feature[$index]);

                        $feature_value_ids = $group->pluck('feature_value_id');

                        // если количество переданных значений хар-тик совпадает с кол-вом хар-тик
                        // найденой сое-страницы и эти значения не отличаются
                        if (count($values) == $feature_value_ids->count() && !$feature_value_ids->diff($values)->count()) :
                            $result = $seo;
                        else:
                            $result = null;
                            $diff = !$diff;
                        endif;
                    });
            });

        endif;


        if (!$diff) :
            return $result;
        else:
            return null;
        endif;
    }


    private function removeQueryParamsByCurrentSeoPage($seo_page): ?string
    {

        if ($this->feature) :

            $result = null;
            $diff = false;

            $seo_page->entity_features->each(function ($ef) use (&$diff) {
                foreach ($this->feature as $key => $values) {
                    if ($key == $ef->feature_id) {
                        foreach ($values as $k => $v) {
                            if ($ef->feature_value_id == $v) {
                                $diff = true;
                                unset($this->feature[$key][$k]);
                            }
                        }
                    }
                    if (count($this->feature[$key]) == 0) {
                        $diff = true;
                        unset($this->feature[$key]);
                    }
                }
            });

            if ($diff):
                $default['feature'] = $this->feature;

                $res = http_build_query($default);
                return request()->path() . '?' . $res;

            endif;

        endif;


        return null;

    }


    /**
     *  From сео-страницы связанной с текущей категорией и не являющейся брендом
     *
     * @param null $category_id
     * @return mixed
     */
    private function findSeoPageWithProductCategoryNotBrand($category_id = null)
    {
        $query = $this->basicCondition()
            ->isBrand(false)
            ->withCategory($category_id)
            ->withFeature()
            ->query;
        return $query->get();
    }

    /**
     * Ищет сео-страницы у которых нет категории
     * @return mixed
     */
    private function findSeoPageWithoutProductCategoryNotBrand()
    {
        $query = $this->basicCondition()
            ->isBrand(false)
            ->withoutCategory()
            ->withFeature()
            ->query;
        return $query->get();
    }


    /**
     * Базовый запрос сео-страницы с ее хар-ками и страницей
     * @return SeoCatalogRedirectService
     */
    private function basicCondition(): SeoCatalogRedirectService
    {
        $this->query = SeoCatalog::with(['entity_features'])->withPage();
        return $this;
    }


    /**
     *  Основное условие поиска по характеристикам
     *
     * @return SeoCatalogRedirectService
     */
    private function withFeature(): SeoCatalogRedirectService
    {
        if ($this->feature) :
            foreach ($this->feature as $feature_id => $feature_value_Ids) {

                $this->query->whereHas('entity_features', function ($q) use ($feature_id, $feature_value_Ids) {
                    $q->where('feature_id', $feature_id)
                        ->whereIn('feature_value_id', $feature_value_Ids);
                });
            }
        endif;

        return $this;
    }


    /**
     * Связывание сео-страницы с категорией по текущему uri
     * @param null $category_id
     * @return SeoCatalogRedirectService
     */
    private function withCategory($category_id): SeoCatalogRedirectService
    {
        $this->query->whereHas('category', function ($query) use ($category_id) {
            $query->where('id', $category_id);
        });

        return $this;
    }


    private function withoutCategory(): SeoCatalogRedirectService
    {
        $this->query->whereNull('product_category_id');
        return $this;
    }


    /**
     * Фильтр хар-тик по типу (бренд)
     *
     * @param $bool
     * @return $this
     */
    private function isBrand($bool): SeoCatalogRedirectService
    {
        $this->query->where('is_brand', $bool);
        return $this;
    }


    /**
     *  Получение категории товара по текущему uri
     * @return mixed
     */
    private function getCategoryProductPage()
    {
        // на активность и опубликованность не проверяем
        // это уже проверил \App\Http\Middleware\PageMiddleware
        return ProductCategory::whereHas('page', function ($query) {
            $query->whereTranslation('slug', $this->uri);
        })->first();
    }


    /**
     *  Получение сео-страницы по текущему uri
     * @return mixed
     */
    private function getSeoPage()
    {
        return SeoCatalog::withAndWhereHas('page', function ($query) {
            $query->whereTranslation('slug', $this->uri);
        })->with('entity_features')->first();
    }

    private function removeQueryParams(array $params, $url = null)
    {
        $query = null;

        if (!$url) {
            $url = url()->current(); // get the base URL - everything to the left of the "?"
            $query = request()->query();
        } else {
            $referer_query = parse_url($url, PHP_URL_QUERY);
            $url = str_replace('?' . $referer_query, '', $url);
            parse_str($referer_query, $query);

        }

        foreach ($params as $param) {
            unset($query[$param]); // loop through the array of parameters we wish to remove and unset the parameter from the query array
        }

        return $query ? $url . '?' . http_build_query($query) : $url;
    }


    private function removeLocaleFromUri(Request $request)
    {
        // текущий префикс языка
        $langPrefix = ltrim($request->route()->getPrefix(), '/');
        // массив доступных активный языков
        $locales = app()->languages->active()->slug();

        if ($locales) {
            if ((bool)$langPrefix && in_array($langPrefix, $locales)) {
                $this->langPrefix = $langPrefix;
                $this->uri = str_replace($langPrefix . '/', '', $request->route()->uri);
            } else {
                $this->uri = $request->route()->uri;
            }
        }
    }


    private function addLocalePrefixToUri(?string $redirectTo): ?string
    {
        if ($this->langPrefix) :
            return $this->langPrefix . '/' . $redirectTo;
        else :
            return $redirectTo;
        endif;
    }
}
