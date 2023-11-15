<?php

use App\DataTables\PermissionsDataTable;
use App\Helpers\PermissionHelper;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\Translations\MenuTranslation;

class BackendMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Menu::truncate();
        MenuTranslation::truncate();

        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);


        // Разделы сайта
        $data = [
            'icon'=>'fas fa-sitemap',
            'type'=>'section'
        ];
        $this->createMenu($data, 'Разделы сайта', $locales);


        // Каталог сайта
        $data = [
            'icon'=>'fa fa-dolly-flatbed',
            'type'=>'catalog'
        ];
        $this->createMenu($data, 'Каталог товаров', $locales);


        // Администрирование
        $data = [
            'icon'=>'fas fa-user-shield',
            'type'=>'admin'
        ];
        $this->createMenu($data, 'Администрирование', $locales);

        // Разработка
        $data = [
            'icon'=>'fas fa-tools',
            'type'=>'developer'
        ];
        $this->createMenu($data, 'Разработка', $locales);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }


    private function createMenu($data, $name, $locales, $root = null)
    {

        foreach ($locales as $locale){
            $data[$locale] = [
                'name'=>$name
            ];
        }

        $node = Menu::create($data);

        if($root) {
            $root->appendNode($node);
        }

        return $node;
    }
}
