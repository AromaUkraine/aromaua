<?php
return [
    // module catalog для страницы каталога
    'catalog' => [
        "name" => "Catalog",
        "description" => "Каталог товаров",
        "alias" => "catalog",
        "type" => "module",
        // роутинг для фронтенда
        'routes' =>[
            'web'=>[
                // роутинг по умолчанию фронтенд (список категории)
                [
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\CatalogController',
                    'action'=>'index'
                ]
            ],
            // роутинг для действия по умолчанию на бэкенде
            'cms'=>config('route-manager.cms')
        ],
    ],


    // standalone routes
    'routes'=>[
        'product_category'=>[
            'web'=>[
                //роутинг для категории
                'view'=>[
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\ProductCategoryController',
                    'action'=>'view'
                ]
            ],
        ],
        'product'=>[
            'web'=>[
                //роутинг для товара
                'index'=>[
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\ProductController',
                    'action'=>'index'
                ],
            ]
        ],
        'seo_catalog'=>[
            'web'=>[
                //роутинг для сео-страницы
                'index'=>[
                    'method'=>'get',
                    'controller'=>'App\\Http\\Controllers\\Web\\SeoCatalogController',
                    'action'=>'index'
                ],
            ]
        ]
    ],
];
