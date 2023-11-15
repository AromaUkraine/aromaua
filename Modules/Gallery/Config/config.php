<?php

return [
    [
        //название компонента
        "name"=>"Gallery",
        // Описание компонента
        "description"=> "Создание галлереи, фото-видео",
        // уникальный ключ !!!!
        "alias"=> "gallery",
        // тип компонента
        "type"=>"widget",
        // навигация внутри админки (компонент NavPage)
        "cms_navigation"=>[
            [
                "label"=>"cms.gallery",
                "icon"=> "",
                "slug"=> "module.page_gallery.index"
            ]
        ]
    ],
     //Включено мягкое удаление
    'softDelete'=>true
];
