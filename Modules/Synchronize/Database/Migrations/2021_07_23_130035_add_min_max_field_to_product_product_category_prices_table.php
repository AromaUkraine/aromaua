<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMinMaxFieldToProductProductCategoryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_product_category_prices', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->decimal('min', 4, 2)->nullable()->after('price');
            $table->decimal('max', 4, 2)->nullable()->after('min');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_product_category_prices', function (Blueprint $table) {
        });
    }
}