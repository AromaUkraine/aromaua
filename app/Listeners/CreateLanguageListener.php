<?php

namespace App\Listeners;

use App\Events\CreateLanguageEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;


class CreateLanguageListener
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
     * @param  CreateLanguageEvent  $event
     * @return void
     */
    public function handle(CreateLanguageEvent $event)
    {

        // Перезаписываем конфиг файл translatable.php
        app()->configuration->save( ['LOCALES'=>app()->languages->all()->slug()] );

        // Создаем копию директории языка по умолчанию, под именем нового языка
        $default = config('app.locale');
        $d_path = resource_path('lang'.DIRECTORY_SEPARATOR.$default);
        $l_path = resource_path('lang'.DIRECTORY_SEPARATOR.$event->language);

        if(is_dir($l_path)){
            \File::deleteDirectory($l_path);
        }

        \File::copyDirectory($d_path, $l_path);

        \Artisan::call('config:clear');
    }
}
