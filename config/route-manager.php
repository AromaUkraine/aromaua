<?php

return [
    'cms'=>[
        [
            'method'=>'get',
            'uri'=>'page/{page}/{name}',
            'type'=>'section',
            'controller'=>'PagesController',
            'action'=>'index',
        ],
        [
            'method'=>'patch',
            'uri'=>'page/{page}/{name}',
            'type'=>'section',
            'controller'=>'PagesController',
            'action'=>'update',
        ]
    ]
];
