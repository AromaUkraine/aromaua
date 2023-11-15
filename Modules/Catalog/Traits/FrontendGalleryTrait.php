<?php


namespace Modules\Catalog\Traits;


use Modules\Gallery\Entities\Gallery;

trait FrontendGalleryTrait
{
    // получение фотогаллереи
   /* public function scopeWithGallery($query, $all = false)
    {
        return $query->with(['gallery' => function ($query) use ($all) {
            if($all) :
                $query->active()->published();
            else:
                $query->where('type', Gallery::TYPE_PHOTO)->active()->published();
            endif;
        }]);
    }*/
}
