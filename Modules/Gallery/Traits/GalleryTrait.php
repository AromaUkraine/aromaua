<?php


namespace Modules\Gallery\Traits;

use Modules\Gallery\Entities\Gallery;

/**
 * Trait GalleryTrait - трейт для подключения модели Gallery к текущей модели
 * @package App\Traits
 */
trait GalleryTrait
{
    /**
     * Связь с галлереей
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function gallery()
    {
        return $this->morphMany(Gallery::class, 'galleriable');
    }

    /**
     *  Связь с изображением
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function image()
    {
        return $this->morphOne(Gallery::class,'galleriable');
    }


    /**
     * Первое фото для галлереи (превью фото)
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function photo_preview()
    {
        return $this->morphOne(Gallery::class, 'galleriable')
            ->where('type', Gallery::TYPE_PHOTO);
    }


    /**
     * @param $query
     * @param false $all
     * @return mixed
     */
    public function scopeWithGallery($query, $all = false)
    {
        return $query->with(['gallery' => function ($query) use($all) {
            if(!$all){
                $query->where('type', Gallery::TYPE_PHOTO);
            }
            $query->active()->published();
        }]);
    }

}
