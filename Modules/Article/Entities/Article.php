<?php

namespace Modules\Article\Entities;

use App\Models\Page;


use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use Modules\Banner\Traits\BannerTrait;
use Illuminate\Database\Eloquent\Model;
use Modules\Gallery\Traits\GalleryTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Traits\ArticleCategoryTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Article extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Трейт подключения к модели галлереи
    use GalleryTrait;

    // Трейт связи со страницей
    use PageTrait;

    // Трейт связи со страницей
    use ArticleCategoryTrait;

    // Трейт с модифицироваными, универсальными запросами
    use QueryTrait;

    // Трейт связи с баннером
    use BannerTrait;

     // Трейт для автоматическое кеширование
     use Cachable;


    public $timestamps = false;

    protected $dates = ['published_at','deleted_at'];

    protected $fillable = ['parent_page_id','published_at'];


    public function scopeLatestPublished($query, ?int $limit = 0)
    {
        $query->orderBy('published_at','desc');
            if($limit)
                $query->limit($limit);
    }

}
