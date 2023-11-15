<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductProductCategoryPriceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_category_price_translations', function (Blueprint $table) {

            $table->id();
            $table->bigInteger('product_product_category_price_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable()->comment('field Name from price_colums table in remote database');
            $table->string('currency')->nullable();


            $table->boolean('publish')->default(false);
            $table->timestamps();

            $table->foreign('product_product_category_price_id')->index('ppcp_id')->references('id')->on('product_product_category_prices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product_category_price_translations');
    }
}
