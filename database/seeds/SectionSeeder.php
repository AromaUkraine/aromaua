<?php

use App\Events\CreateSectionEvent;
use App\Models\Menu;
use App\Models\Page;
use App\Models\Permission;
use App\Models\Section;
use App\Models\Template;
use App\Models\Translations\PageTranslation;
use App\Services\PermissionService;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Section::truncate();
        Page::truncate();
        PageTranslation::truncate();

        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);

        $template = Template::first();

        $this->createRecords($locales, 'Главная','main', $template);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    protected function createRecords($locales, $name, $slug, $template)
    {
        $data = [
            'template_id'=>$template->id,
        ];
        foreach ($locales as $lang)
        {
            $data[$lang]=[
                'name'=>$name,
                'slug'=>$slug,
                'publish'=>true
            ];
        }

        event(new CreateSectionEvent($data));

    }
}
