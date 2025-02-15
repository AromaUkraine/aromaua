<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(CatalogTemplateDatabaseSeeder::class);
       // $this->call(CatalogPageDatabaseSeeder::class);
        $this->call(CurrencyTableSeeder::class);
        $this->call(PriceTypeTableSeeder::class);
    }
}
