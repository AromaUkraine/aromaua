<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDataFieldToProductProductCategoryPriceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_product_category_price_translations', function (Blueprint $table) {
            $table->json('data')->default(json_encode([]))->after('currency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_product_category_price_translations', function (Blueprint $table) {

        });
    }
}