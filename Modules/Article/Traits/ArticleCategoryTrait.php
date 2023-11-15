<?php


namespace Modules\Article\Traits;

use Modules\Article\Entities\ArticleCategory;

/**
 * Трейт связи статьи с категориями
 *
 * Trait ArticleCategoryTrait
 * @package Modules\Article\Traits
 */
trait ArticleCategoryTrait
{
    /**
     * Связь с категориями
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(ArticleCategory::class, 'article_article_category');
    }
}
