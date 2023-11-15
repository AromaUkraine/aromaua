<?php

use App\Models\Language;
use Illuminate\Database\Seeder;
use \App\Helpers\delete;
use App\Models\Translations\LanguageTranslation;


class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Language::truncate();
        LanguageTranslation::truncate();

        $locales = env('LOCALES', config('translatable.locales') );

        foreach($locales as $locale) {

            $data = [
                'short_code'=>$locale,
            ];
            $language = Language::create($data);

            $arr = [];
            foreach ($locales as $lang)
            {
                $arr[$lang]=[
                    'name'=>$locale,
                    'short_name'=>$locale
                ];
            }

            $language->update($arr);
        }

    }

    private function make( $locale)
    {

    }
}
