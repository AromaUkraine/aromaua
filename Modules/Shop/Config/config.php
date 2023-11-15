<?php

return [
    [
        //название компонента
        "name"=>"Countries",
        // Описание компонента
        "description"=> "Создание стран",
        // уникальный ключ !!!!
        "alias"=> "countries",
        // тип компонента
        "type"=>"widget",
        // навигация внутри админки (компонент NavPage)
        "cms_navigation"=>[
            [
                "label"=>"cms.countries",
                "icon"=> "",
                "slug"=> "module.page_country.index"
            ]
        ]
    ],
    'contact' => [
        "name" => "Contact",
        "description" => "Страница контактов",
        "alias" => "contact",
        "type" => "module",
        // роутинг для фронтенда
        'routes' =>[
            'web'=>[
                // роутинг по умолчанию фронтенд (список категории)
                [
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\ContactController',
                    'action'=>'index'
                ]
            ],
            // роутинг для действия по умолчанию на бэкенде
            'cms'=>config('route-manager.cms')
        ],
    ],
    //Включено мягкое удаление
    'softDelete'=>true
];
