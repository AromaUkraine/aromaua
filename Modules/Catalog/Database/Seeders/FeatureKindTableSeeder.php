<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\FeatureKind;


class FeatureKindTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Model::unguard();
        FeatureKind::truncate();

        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);

        $this->makeKind(FeatureKind::IS_NUMBER,'Число', $locales);
        $this->makeKind(FeatureKind::IS_COLOR,'Цвет', $locales);
        $this->makeKind(FeatureKind::IS_BRAND,'Производитель', $locales);
        $this->makeKind(FeatureKind::IS_COUNTRY,'Страна-производитель', $locales);

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function makeKind($key, $name, $locales)
    {
        $data['key'] = $key;
        foreach ($locales as $locale)
        {
            $data[$locale] = [
                'name'=>$name
            ];
        }
        FeatureKind::create($data);
    }
}
