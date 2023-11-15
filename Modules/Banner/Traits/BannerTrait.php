<?php


namespace Modules\Banner\Traits;


use Modules\Banner\Entities\Banner;

/**
 * Trait BannerTrait - трейт для подключения модели Banner к текущей модели
 * @package App\Traits
 */
trait BannerTrait
{

    /**
     * Связь с моделью баннеров
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function entity_banner()
    {
        return $this->morphMany(Banner::class, 'bannerable');
    }
}
