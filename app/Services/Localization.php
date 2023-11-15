<?php

namespace App\Services;

use App\Helpers\ArrayHelper;
use App\Models\Language;


class Localization
{

    public function locale()
    {

        try {

            $segment = request()->segment(1, '');

            $locales = app()->languages->active($segment)->slug(); //Language::whereIn('short_code',[$segment, config('app.locale')])->whereActive(true)->get();

            if (!ArrayHelper::cnt($locales, 0)) {

                //удаляем из массива язык по умолчанию (чтобы небыло ссылок с дефолтным языком)
                if (($key = array_search(config('app.locale'), $locales)) !== FALSE) {
                    unset($locales[$key]);
                }

                if ((bool)$segment && in_array($segment, $locales)) {
                    return $segment;
                }
            }
        } catch (\Exception $e) {
        }


        return "";
    }
}