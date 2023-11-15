<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTextPriceFieldToProductProductCategoryPriceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_product_category_price_translations', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->string('text')->nullable()
                ->comment('поле text в разделе price_list которое в свою очередь находится в разделе price')
                ->after('locale');
            $table->string('price', 10)->nullable()
                ->after('text');
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
