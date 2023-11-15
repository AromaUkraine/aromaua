<?php

return [
    // module text-page для страниц с текстом
    'text-page' => [
        "name" => "TextPage",
        "description" => "Модуль текстовых страниц",
        "alias" => "text-page",
        "type" => "module",
        // роутинг для фронтенда
        'routes' =>[
            'web'=>[
                // роутинг по умолчанию фронтенд
                [
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\TextPageController',
                    'action'=>'index'
                ]
            ],
            // роутинг для действия по умолчанию на бэкенде
            'cms'=>config('route-manager.cms')
        ],
    ],
];
