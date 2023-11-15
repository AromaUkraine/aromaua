<?php

namespace Modules\Article\Entities;

use App\Models\Page;

use App\Traits\PageTrait;
use App\Traits\QueryTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Article\Traits\ArticleTrait;
use Modules\Developer\Entities\Template;
use Modules\Gallery\Traits\GalleryTrait;

class ArticleCategory extends Model
{
    // Трейт "мягкого удаления"
    use SoftDeletes;

    // Трейт подключения к модели галлереи
    use GalleryTrait;

    // Трейт связи со страницей
    use PageTrait;

    // Трейт связи со статьями
    use ArticleTrait;

    // Трейт с модифицироваными, универсальными запросами
    use QueryTrait;


    public $timestamps = false;

    protected $dates = ['deleted_at'];

    protected $fillable = ['parent_page_id'];

}
