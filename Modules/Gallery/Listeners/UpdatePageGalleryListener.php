<?php

namespace Modules\Gallery\Listeners;

use App\Services\PublishAttribute;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Service\VideoService;

class UpdatePageGalleryListener
{


    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle(object $event)
    {
        // подготавливаем данные для сохранения
        $data = app(PublishAttribute::class)->make($event->request);

        if($event->gallery->type == Gallery::TYPE_PHOTO) :
            $this->makePhoto($data, $event);
        endif;

        if($event->gallery->type == Gallery::TYPE_VIDEO) :
            $event->data = $data;
            $data = app(VideoService::class)->setData($event);
            $event->gallery->update($data);
        endif;
    }

    private function makePhoto($data, object $event)
    {
        // список всех доступных языков
        $locales = app()->languages->all()->slug();

        foreach ($locales as $locale) {

            foreach ($data[$locale] as $key=>$value){

                if( $key == 'image' ) :
                    $image = json_decode($data[$locale]['image'], true)[0];
                    $data[$locale]['image'] = $image;
                else :
                    $data[$locale][$key] = $value;
                endif;

            }
        }

        $event->gallery->update($data);
    }

}