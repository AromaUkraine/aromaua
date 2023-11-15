<?php

namespace  Modules\Synchronize\Service;

class TranslationService
{

    private $locales;

    public function __construct()
    {
        $this->locales = app()->languages->all()->slug();
    }


    public function make(array $data, array $translate_data): array
    {
        foreach($this->locales as $locale){

            foreach($translate_data as $key=>$value){
                $data[$locale][$key] = $value;
            }
        }

        return $data;
    }
}
