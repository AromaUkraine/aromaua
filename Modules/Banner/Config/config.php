<?php

return [
    [
        //название компонента
        "name"=>"Banner",
        // Описание компонента
        "description"=> "Создание баннеров, слайдеров",
        // уникальный ключ !!!!
        "alias"=> "banner",
        // тип компонента
        "type"=>"widget",
        // навигация внутри админки (компонент NavPage)
        "cms_navigation"=>[
            [
                "label"=>"cms.banner",
                "icon"=> "",
                "slug"=> "module.page_banner.index"
            ]
        ]
    ],
    //Включено мягкое удаление
    'softDelete'=>true
];
