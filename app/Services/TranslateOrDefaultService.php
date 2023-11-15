<?php


namespace App\Services;


class TranslateOrDefaultService
{

    public function get($model, $field = null, $all = false)
    {
        $this->field = $field;

        $current = app()->getLocale();
        $locales = array_diff(app()->languages->all()->slug(), [$current]);

        $translations = $model->getTranslationsArray();

        if (isset($translations[$current]) && !empty($translations[$current]) && isset($translations[$current][$field])) :
            return $translations[$current][$field];
        else :
            foreach ($locales as $locale) {
                if (isset($translations[$locale][$field])) {
                    return $translations[$locale][$field];
                }
            }
        endif;

        return null;
    }
}