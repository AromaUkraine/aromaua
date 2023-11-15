<?php


namespace App\Traits;


trait JsonDataTrait
{
    public $default_json_data = [
        'routes' => [
            'web' => [
                [
                    'method' => 'get',
                    'controller' => '',
                    'action' => ''
                ]
            ],
            'cms' => [
                [
                    'method' => 'get',
                    'uri' => 'page/{name}/{page}',
                    'type' => 'section',
                    'controller' => 'PagesController',
                    'action' => 'index',
                ],

                [
                    'method' => 'patch',
                    'uri' => 'page/{name}/{page}',
                    'type' => 'section',
                    'controller' => 'PagesController',
                    'action' => 'update',
                ],
            ],
        ]
    ];


    /**
     * Декодирует аттрибут data когда к нему обращаются
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value, true);
    }

    /**
     * Кодирует аттрибут data перед сохранением
     * @param $value
     */
    public function setDataAttribute($value)
    {
        $this->attributes['data'] = json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Возвращает из массива роутов массив по аттрибуту web или null
     * @return mixed|null
     */
    public function getWebAttribute()
    {
        return $this->getJsonData('routes', 'web');
    }

    /**
     * Возвращает из массива роутов массив по аттрибуту cms или null
     * @return mixed|null
     */
    public function getCmsAttribute()
    {
        return $this->getJsonData('routes', 'cms');
    }

    /**
     * @param $attribute
     * @return mixed|null
     */
    public function getRoutesAttribute()
    {
        return $this->getJsonData('routes');
    }

    public function getComponentsAttribute()
    {
        return $this->getJsonData('components');
    }


    /**
     *  Возвращает массив по ключу или елемент массива attribute по ключу, если ключа или елемента не нашлось возвращает null
     * @param $key
     * @param string $attribute
     * @return mixed|null
     */
    public function getJsonData($key, string $attribute = "")
    {
        if (!is_array($this->data)) {
            $data = json_decode($this->data, true);
        } else {
            $data = $this->data;
        }

        if (isset($data[$key])) {
            if ($attribute) {
                return $data[$key][$attribute];
            } else {
                return $data[$key];
            }
        }

        return null;
    }
}