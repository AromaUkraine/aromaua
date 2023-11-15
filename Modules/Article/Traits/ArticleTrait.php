<?php


namespace Modules\Article\Traits;

use Modules\Article\Entities\Article;

/**
 * Трейт связи категории со статьями
 * Trait ArticleTrait
 * @package Modules\Article\Traits
 */
trait ArticleTrait
{

    /**
     * Связь со статьями
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    /**
     * кол-во связанных с категорией статей
     * @param $query
     * @return mixed
     */
    public function scopeArticleCount($query){
        return $query->with('articles')->count();
    }
}
