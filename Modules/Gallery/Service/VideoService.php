<?php


namespace Modules\Gallery\Service;


use Modules\Gallery\Entities\Gallery;

class VideoService
{
    public function setData($event)
    {
        $data = null;

        if(isset($event->data['link']) && !empty($event->data['link']))
        {
            // список всех доступных языков
            $locales = app()->languages->all()->slug();

            $data['link'] = $event->data['link'];
            $data['type'] = $event->data['type'];

            // если не заполнена картинка - генерируем ее из ссылки на видео
            if(empty($event->data['image'])) :
                $image = app(Gallery::class)->setYoutubePreview($data['link']);
            else :
                // преобразовываем json картинок в массив
                $img = json_decode($event->data['image'] , true);
                $image = $img[0];
            endif;

            foreach ($locales as $locale) :
                if(isset($event->data[$locale])) :
                    foreach ($event->data[$locale] as $key=>$value) :
                        $data[$locale][$key] = $value;
                    endforeach;
                    $data[$locale]['image'] = $image;
                endif;
            endforeach;

        }

        return $data;
    }
}
