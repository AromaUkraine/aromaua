<?php


namespace App\Services;


class CacheKeysService
{
    const FRONTEND_MENU_KEY = 'fr_m';

    const PAGE_ACTIVE_PUBLISH = 'p_a_p';


    public function getKey($key){
        return $key.app()->getLocale();
    }

    public function reset($key)
    {
        // список всех языков сайта
        $locales = app()->languages->all()->slug();

        foreach ($locales as $locale)
        {
            \Artisan::call('cache:forget '.$key.$locale);
        }
    }

}
