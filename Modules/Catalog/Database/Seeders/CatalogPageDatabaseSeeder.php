<?php


namespace Modules\Catalog\Database\Seeders;


use App\Events\CreatePageEvent;
use Illuminate\Database\Seeder;
use Modules\Developer\Entities\Template;

class CatalogPageDatabaseSeeder extends Seeder
{
    public function run()
    {
        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);

        $catalog = Template::where('type','catalog')->first();
        $this->createPage($catalog, 'Каталог', 'catalog', false, false, $locales);
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
