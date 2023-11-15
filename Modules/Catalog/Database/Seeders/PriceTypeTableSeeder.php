<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Currency;
use Modules\Catalog\Entities\PriceType;

class PriceTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        PriceType::truncate();
        $base_currency = Currency::base()->first();

        $data = [
            'currency_id' => $base_currency->id,
            'name' => 'Розничная цена',
            'key'  => 'default'
        ];

        PriceType::create($data);
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
