<?php
namespace Modules\Developer\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Developer\Entities\Template;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Template::truncate();

        $this->main();

    }

    private function main()
    {
        $json= [
            'components'=>[
                [
                    "name" => "Main",
                    "description" => "Main",
                    "alias" => "main",
                    "type" => "module",
                    'data'=>[
                        'routes'=>[
                            'cms' => config('route-manager.cms'),
                            'web' => [
                                [
                                    'method'=>'get',
                                    'controller'=>Template::RESOURCE_WEB_CONTROLLER_PATH.'MainController',
                                    'action'=>'index'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $data = [
            'name'=>'Шаблон главной страницы',
            'type'=>'main',
            'is_main'=>true,
            'data' =>$json
        ];
        Template::create($data);
    }


}
