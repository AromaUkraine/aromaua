<?php

return [
    // конфигурация для статей
    'article' => [
        "name" => "Articles",
        "description" => "Статьи",
        "alias" => "articles",
        "type" => "module",
        // режим мягкого удаления
        'routes' => [
            // роутинг для действия по умолчанию на фронтенде
            'web' => [
                [
                    'method' => 'get',
                    'controller' => 'App\\Http\\Controllers\\Web\\ArticleController',
                    'action' => 'index'
                ]
            ],
            // роутинг для действия по умолчанию на бэкенде
            'cms' => config('route-manager.cms')
        ],
        // навигация внутри админки (компонент NavPage)
        "cms_navigation" => [
            [
                "label" => "cms.articles",
                "icon" => "",
                "slug" => "module.article.index"
            ]
        ]
    ],
    // конфигурация для категорий статей
    'category' => [
        "name" => "ArticleCategories",
        "description" => "Категории статей",
        "alias" => "article-categories",
        "type" => "module",
        'routes' => [
            // роутинг для действия по умолчанию на фронтенде
            'web' => [
                [
                    'method' => 'get',
                    'controller' => 'App\\Http\\Controllers\\Web\\ArticleCategoryController',
                    'action' => 'index'
                ],
            ],
            // роутинг для действия по умолчанию на бэкенде
            'cms' => config('route-manager.cms')
        ],
        // навигация внутри админки (компонент NavPage)
        "cms_navigation" => [
            [
                "label" => "cms.article.categories",
                "icon" => "",
                "slug" => "module.article_category.index"
            ],
            [
                "label" => "cms.articles",
                "icon" => "",
                "slug" => "module.article.index"
            ]
        ]
    ],
    'softDelete' => true,
];
