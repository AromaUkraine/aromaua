<?php


namespace Modules\Catalog\Database\Seeders;


use Illuminate\Database\Seeder;
use Modules\Developer\Entities\Template;

class CatalogTemplateDatabaseSeeder extends Seeder
{
    public function run()
    {

        $json= [
            'components'=>[
                [
                    "name" => "Catalog",
                    "description" => "catalog",
                    "alias" => "catalog",
                    "type" => "module",
                    'data'=>[
                        'routes'=>[
                            'cms' => config('route-manager.cms'),
                            'web' => [
                                [
                                    'method'=>'get',
                                    'controller'=>"App\\Http\\Controllers\\Web\\CatalogController",
                                    'action'=>'index'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $data = [
            'name'=>'Шаблон страницы каталога',
            'type'=>'catalog',
            'data' =>$json
        ];
        Template::create($data);

    }
}
