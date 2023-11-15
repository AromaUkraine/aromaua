<?php

namespace Modules\Gallery\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePhotoGalleryListener
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


        try{
            \DB::beginTransaction();

            if(isset($event->data['image']) && !empty($event->data['image']))
            {
                $gallery = null;
                // список всех доступных языков
                $locales = app()->languages->all()->slug();
                // преобразовываем json картинок в массив
                $images = json_decode($event->data['image'] , true);
                //собираем массивы галлереи по количеству картинок
                foreach ($locales as $locale) {
                    foreach ($images as $key=>$value){
                        $gallery[$key][$locale]['image'] = $value[0];
                    }
                }

                // Сохраняем записи в галлереи
                if($gallery) {
                    foreach ($gallery as $item){
                        $event->entity->gallery()->create($item);
                    }
                }
            }

            \DB::commit();
        }catch (\Exception $e){

            \DB::rollback();
            dd($e->getMessage());
        }
    }
}
