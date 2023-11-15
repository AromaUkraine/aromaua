<?php

namespace Modules\Catalog\Listeners;

use App\Services\PublishAttribute;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Modules\Catalog\Entities\FeatureKind;
use Modules\ColorScheme\Entities\ColorScheme;
use Nwidart\Modules\Facades\Module;

class CreateFeatureValueListener
{


    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $data = app(PublishAttribute::class)->make($event->request);

        if($event->kind->key == FeatureKind::IS_COLOR && isset($data['color_scheme_id'])) :
            // добавляем название цвета в feature_value
            $event->request['color_scheme_id'] = $data['color_scheme_id'];
        endif;

        $event->entity = $event->kind->feature_values()->create($data);
    }






//    private function dataModifyWithColorScheme(array $data, $event): array
//    {
//
//        if(isset($data['color_scheme_id'])) :
//            // если есть модуль ColorScheme
//            if(Module::find('ColorScheme')):
//
//                $locales = app()->languages->all()->slug();
//
//                foreach ($locales as $locale){
//
//                    if(isset($data[$locale]) && !empty($data[$locale])){
//                        $color = ColorScheme::find($data['color_scheme_id']);
//                        if($color->translate($locale)) {
//                            $data[$locale]['name'] = $color->translate($locale)->name;
//                        }
//                    }
//
//                }
//                unset($data['name']);
//                $event->request['color_scheme_id'] = $data['color_scheme_id'];
//            endif;
//
//        endif;
//
//        return $data;
//
//    }
}
