<?php


namespace App\Traits;


use App\Models\Page;
use App\Services\ModelService;
use Modules\Catalog\Entities\ProductCategory;
use Modules\Catalog\Entities\SeoCatalog;
use Modules\Developer\Entities\Template;

trait PageTrait
{

    /**
     * Возврашает страницу к которой был прикреплен эта модель
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rootPage()
    {
        return $this->belongsTo(Page::class, 'parent_page_id', 'id');
    }

    /**
     * Возвращает страницу этой модели
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function page()
    {
        return $this->morphOne(Page::class, 'pageable');
    }


    /***
     *  Возвращает подготовленный запрос активых модулей текущей страницы
     *
     * @param $class
     * @return mixed
     */
    public function getActivePublishedModulesFromPage($class)
    {
        return $class::where('parent_page_id', $this->id)->withPage(true, true, $class);
    }


    /**
     *
     * @param $query
     * @param bool $active - only active (default true)
     * @param bool $publish - only published (default true )
     * @param null $class
     * @return mixed
     */
    public function scopeWithPage($query, $active = true, $publish = true, $class = null)
    {
        if (!$class)
            $class = self::class;

        $table = (new $class)->getTable();

        return $query
            ->join('pages', function ($join) use ($class, $table, $active, $publish) {
                $join->on('pages.pageable_id', '=', $table . '.id')
                    ->where('pages.pageable_type', $class)
                    ->where('pages.active', $active)
                    ->join('page_translations', function ($join) use ($publish) {
                        $join->on('pages.id', '=', 'page_translations.page_id')
                            ->where('publish', $publish)
                            ->where('locale', app()->getLocale());
                    });
            })->select('pages.id as page_id', 'pages.*', 'page_translations.id as page_translations_id', 'page_translations.*', $table . '.*', $table . '.id as id');
    }

    public function scopeJoinPage($query, $active = null, $publish = null, $class = null, $locale = null)
    {

        if (!$class)
            $class = self::class;

        if (!$locale)
            $locale = app()->getLocale();

        $table = (new $class)->getTable();

        return $query
            ->join('pages', function ($join) use ($class, $table, $active, $publish, $locale) {
                $join->on('pages.pageable_id', '=', $table . '.id')
                    ->where('pages.pageable_type', $class);

                    if($active)
                        $join->where('active', $active);

                $join->join('page_translations', function ($join) use ($publish, $locale) {
                        $join->on('pages.id', '=', 'page_translations.page_id');

                            if($publish)
                                $join->where('publish', $publish);

                        if(is_array($locale)){
                            $join->whereIn('locale', $locale);
                        }else{
                            $join->where('locale', $locale);
                        }

                });
            })->select('pages.id as page_id', 'pages.*', 'page_translations.id as page_translations_id', 'page_translations.*', $table . '.*', $table . '.id as id');
    }

    public function scopeJoinPageAll($query, $active = true, $publish = true, $class = null)
    {
        if (!$class)
            $class = self::class;

        $table = (new $class)->getTable();

        return $query
            ->join('pages', function ($join) use ($class, $table, $active, $publish) {
                $join->on('pages.pageable_id', '=', $table . '.id')
                    ->where('pages.pageable_type', $class)
                    ->join('page_translations', function ($join) use ($publish) {
                        $join->on('pages.id', '=', 'page_translations.page_id');
                    });
            })->select('pages.id as page_id', 'pages.*', 'page_translations.id as page_translations_id', 'page_translations.*', $table . '.*', $table . '.id as id');
    }


    public function scopeLatestPage($query, $field = null)
    {
        $condition = $field ?? 'created_at';

        return $query->orderByTranslation($condition, 'desc');
    }


    public function scopeJoinTranslation($query, $publish = null, ?string $slug = null, ?string $locale = null)
    {
        if (!$locale)
            $locale = app()->getLocale();


        return $query->join('page_translations', function ($join) use ($publish, $slug, $locale) {
            $join->on('pages.id', '=', 'page_translations.page_id')
                ->where('locale', $locale);

            if($publish)
                $join->where('publish', $publish);

            if ($slug)
                $join->where('slug', $slug);

        })
            ->select('page_translations.id as page_translations_id', 'page_translations.*', 'pages.id as id', 'pages.*');
    }

    public function scopeBelongsPage($query,  $belongs_id, $active = true, $publish = true, $class=null, $locale = null)
    {

        if (!$class)
            $class = self::class;

        if (!$locale)
            $locale = app()->getLocale();

        $table = (new $class)->getTable();

        return $query
            ->join('pages', function ($join) use ($class, $table, $belongs_id, $active, $publish, $locale) {
                $join->on('pages.id', '=', $table . '.'. $belongs_id);

                if($active)
                    $join->where('pages.active', $active);

                $join->join('page_translations', function ($join) use ($publish, $locale) {
                    $join->on('pages.id', '=', 'page_translations.page_id');

                    if($publish)
                        $join->where('page_translations.publish', $publish);

                    $join->where('page_translations.locale', $locale);
                });
            })->select('pages.id as page_id', 'pages.*', 'page_translations.id as page_translations_id', 'page_translations.*', $table . '.*', $table . '.id as id');

    }

    /***
     * Объединенное условие активности и опубликованности
     * @param $query
     * @param string|null $locale
     * @return mixed
     */
    public function scopeActual($query, ?string $locale = null)
    {
        if (!$locale)
            $locale = app()->getLocale();

        return $query
            ->active()
            ->published()
            ->whereTranslation('locale', $locale);
    }


    public function scopeWithTypes($query, ?array $types = null)
    {
        if (!$types)
            $types = [Template::class, ProductCategory::class, SeoCatalog::class];

        return $query->whereIn('pageable_type', $types);

    }

}
