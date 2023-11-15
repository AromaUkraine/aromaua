<?php

namespace App\Listeners;

use App\Services\ImageService;
use App\Services\PublishAttribute;
use App\Services\RobotsTxtService;

class SettingUpdateListener
{


    /**
     * @param $event
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($event)
    {

        switch ($event->request->input('key')):

            case 'logo':
                $data = $this->makeImage($event);
            break;

            case 'robots':
                $data = $this->makeRobots($event);
            break;

            default:
                $data = $event->request->all();
        endswitch;

        $event->setting->update($data);
    }




    /**
     * Содержание поля value приходит в формате json как массив
     * ImageService преобразует его в нормальное значение и возвращает в поле value строку - путь к картинке
     * если нужен массив картинок то нужно указать 3ий параметр ImageService::MULTIPLE
     * @param object $event
     * @return mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeImage(object $event)
    {
        return app(ImageService::class)->make('value',$event->request->all());
    }


    private function makeSwitcher(object $event)
    {
        $data = app(PublishAttribute::class)->make($event->request->all());
        dump($data);
        $locale = config('app.fallback_locale');

        if(isset($data[$locale]) && !isset($data[$locale]['value']))
            $data[$locale]['value'] = 0;

        return $data;
    }

    /**
     *  Записывает в файл robots.txt value
     * @param object $event
     * @return mixed
     */
    private function makeRobots(object $event)
    {
        $data = $event->request->all();
        $locale = config('app.fallback_locale');

        if(isset($data[$locale]) && isset($data[$locale]['value'])):
            $value = $data[$locale]['value'];
        else:
            $value = '';
        endif;

        app( RobotsTxtService::class)->put($value);

        return $data;
    }
}
