<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Catalog\Database\Seeders\CatalogDatabaseSeeder;
use Modules\Catalog\Database\Seeders\FeatureDatabaseSeeder;
use Modules\Developer\Database\Seeders\DeveloperDatabaseSeeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(LanguageTableSeeder::class);

        // module Modules\Developer
        $this->call(DeveloperDatabaseSeeder::class);

        $this->call(PageSeeder::class);
        $this->call(BackendMenuTableSeeder::class);
        $this->call(FrontendMenuSeeder::class);

        // module Modules\Catalog
        $this->call(CatalogDatabaseSeeder::class);
        // module Modules\Feature
        $this->call(FeatureDatabaseSeeder::class);



        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        //обновление бекэнд меню ( самым последним !!!)
        \Illuminate\Support\Facades\Artisan::call('menu:refresh');
    }
}
