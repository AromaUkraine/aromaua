<?php

namespace Modules\Gallery\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class UpdatePhotoGalleryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $gallery = null;
        // список всех доступных языков
        $locales = app()->languages->all()->slug();

        foreach ($locales as $locale) {

            foreach ($event->data[$locale] as $key=>$value){

                if( $key == 'image') :
                    $image = json_decode($event->data[$locale]['image'], true)[0];
                    $gallery[$locale]['image'] = $image;
                else :
                    $gallery[$locale][$key] = $value;
                endif;
            }
        }

        $event->gallery->update($gallery);
    }
}
