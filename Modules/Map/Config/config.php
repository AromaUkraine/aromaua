<?php

return [
    [
        //название компонента
        "name" => "Google Map",
        // Описание компонента
        "description" => "Google Map",
        // уникальный ключ !!!!
        "alias" => "google-map",
        // тип компонента
        "type" => "widget",
        // навигация внутри админки (компонент NavPage)
        "cms_navigation" => [
            [
                "label" => "cms.map",
                "icon" => "",
                "slug" => "module.page_google_map.index"
            ]
        ]
    ],
    //Включено мягкое удаление
    'softDelete'=>true
];
