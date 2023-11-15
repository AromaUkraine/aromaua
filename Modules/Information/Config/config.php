<?php

return [
    [
        //название компонента
        "name" => "Information",
        // Описание компонента
        "description" => "Информационный блок",
        // уникальный ключ !!!!
        "alias" => "information",
        // тип компонента
        "type" => "widget",
        // навигация внутри админки (компонент NavPage)
        "cms_navigation" => [
            [
                "label" => "cms.repeating",
                "icon" => "",
                "slug" => "module.page_info.index"
            ]
        ]
    ],
    //Включено мягкое удаление
    'softDelete'=>true
];
