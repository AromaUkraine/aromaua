<?php


namespace App\Services;


class TranslationDataService
{
    private $locales;

    public function __construct()
    {
        $this->locales = app()->languages->all()->slug();
    }

    public function compare(array $data, array $translate_data): array
    {
        foreach($this->locales as $locale){

            foreach($translate_data as $key=>$value){
                $data[$locale][$key] = $value;
            }
        }

        return $data;
    }

}
