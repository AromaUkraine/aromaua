<?php

namespace Modules\Gallery\Listeners;

use App\Services\PublishAttribute;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Gallery\Entities\Gallery;
use Modules\Gallery\Service\VideoService;

class CreatePageGalleryListener
{


    /**
     * Handle the event.
     *
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $data = app(PublishAttribute::class)->make($event->request);

        if ($event->type == Gallery::TYPE_PHOTO):
            $data['parent_page_id'] = $event->page->id;
            $data['page_component_id'] = $event->pageComponent->id;
            $this->makeImage($data);
        endif;

        if ($event->type == Gallery::TYPE_VIDEO):
            $event->data = $data;
            $data = app(VideoService::class)->setData($event);
            $data['parent_page_id'] = $event->page->id;
            $data['page_component_id'] = $event->pageComponent->id;
            Gallery::create($data);
        endif;
    }



    private function makeImage($data)
    {
        // преобразовываем json картинок в массив
        $images = json_decode($data['image'], true);
        unset($data['image']);
        // список всех доступных языков
        $locales = app()->languages->all()->slug();

        foreach ($images as $key => $value) {
            foreach ($locales as $locale) {
                $data[$locale]['image'] = $value[0];
            }

            Gallery::create($data);
        }
    }
}