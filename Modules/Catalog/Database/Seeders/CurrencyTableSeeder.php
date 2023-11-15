<?php

namespace Modules\Catalog\Database\Seeders;

use App\Models\Translations\CurrencyTranslation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Currency;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Currency::truncate();
        CurrencyTranslation::truncate();

        $loc = env('LOCALES',config('app.fallback_locale') );
        $locales = explode('.',$loc);

        $data = [
            'iso' => 'UAH',
            'symbol' => '₴',
            'html_code' => '&#8372;',
            'unicode' => 'U+20B4',
            'type' => Currency::BASE_CURRENCY_TYPE
        ];
        foreach ($locales as $locale){
            $data[$locale]=[
                'name'=>'Гривна',
                'short_name'=>'грн.',
            ];
        }

        Currency::create($data);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
