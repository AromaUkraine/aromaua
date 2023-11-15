<?php

use App\Events\CreatePageEvent;

use App\Models\Page;
use App\Models\Permission;
use App\Models\Translations\PageTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Modules\Developer\Entities\Template;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Page::truncate();
        PageTranslation::truncate();
        Permission::where('data','!=','')->delete();

        \Illuminate\Support\Facades\Artisan::call('config:cache');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        if(Config::has('translatable.locales')){
            $locales = \config('translatable.locales');
        }else{
            $loc = env('LOCALES',config('app.fallback_locale') );
            $locales = explode('.',$loc);
        }

        $main = Template::where('type','main')->first();
        $this->createPage($main, 'Главная', 'main', true, true, $locales);

    }

    private function createPage($template, $name, $slug, $active, $publish, $locales)
    {
        $data = [
            'active'=>$active,
            'template_id'=>$template->id
        ];
        foreach ($locales as $locale){
            $data[$locale]=[
                'name'=>$name,
                'slug'=>$slug,
                'publish'=>$publish,
            ];
        }

        event(new CreatePageEvent($data));
    }


}
