<?php

namespace Modules\Gallery\Entities;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Gallery\Entities\GalleryTranslation
 *
 * @property int $id
 * @property int $gallery_id
 * @property string $locale
 * @property string|null $image
 * @property string|null $name
 * @property string|null $alt
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation all($columns = [])
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation avg($column)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation cache(array $tags = [])
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation cachedValue(array $arguments, string $cacheKey)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation count($columns = '*')
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation disableModelCaching()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation flushCache(array $tags = [])
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation getModelCacheCooldown(\Illuminate\Database\Eloquent\Model $instance)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation inRandomOrder($seed = '')
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation insert(array $values)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation isCachable()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation max($column)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation min($column)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation query()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation sum($column)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation truncate()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereAlt($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereCreatedAt($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereGalleryId($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereId($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereImage($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereLocale($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereName($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation wherePublish($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation whereUpdatedAt($value)
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|GalleryTranslation withCacheCooldownSeconds(?int $seconds = null)
 * @mixin \Eloquent
 */
class GalleryTranslation extends Model
{
    use Cachable;

    protected $fillable = ['image','name','alt','publish'];
}
