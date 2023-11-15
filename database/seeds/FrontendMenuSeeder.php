<?php

use App\Models\Menu;
use Illuminate\Database\Seeder;

class FrontendMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menu = Menu::frontend()->withTrashed()->get();

        $menu->each->forceDelete();

        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);

        $data = [
            'type'=>'main_menu',
            'from'=>Menu::FRONTEND
        ];
        $this->createMenu($data, 'Основное меню', $locales);

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
