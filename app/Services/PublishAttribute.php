<?php


namespace App\Services;


class PublishAttribute
{

    private $locales;

    public function __construct()
    {
        $this->locales = app()->languages->all()->slug();
    }

    public function make($request = null ){

        $request_data = ($request) ?? request()->all();

        $data = request()->all();

        foreach ($this->locales as $locale)
        {
            if(!isset($request_data[$locale]['publish'])){

                $data[$locale] = [];
                if(isset($request_data[$locale])) {
                    foreach ($request_data[$locale] as $key=>$value){
                        $data[$locale][$key]=$value;
                    }
                    $data[$locale]['publish'] = false;
                    request()->request->add($data);
                }

            }else{
                $data[$locale] = [];
                foreach ($request_data[$locale] as $key=>$value){
                    $data[$locale][$key]=$value;
                }
                $data[$locale]['publish'] = true;

            }
        }

        // странное поведение Grammar::parameterize()
        // иногда проходит сохранение без ошибок, а иногда ругается на то что есть массив enable
        if(isset($data['enable']))
            unset($data['enable']);

        if(isset($data['_method']))
            unset($data['_method']);

        if(isset($data['_token']))
            unset($data['_token']);

        return $data;
    }
}
