<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldKodKatochkiPriceToProductCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_categories', function (Blueprint $table) {

            $table->string('code_1c')->unique()->after('order')->comment('field kod_katochki_price in remote database');
            $table->json('data')->nullable()->after('code_1c')->comment('all data from remote database in json format');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropColumn('code_1c');
            $table->dropColumn('data');
        });
    }
}
