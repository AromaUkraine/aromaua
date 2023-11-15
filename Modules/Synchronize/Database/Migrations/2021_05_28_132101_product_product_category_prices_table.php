<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductProductCategoryPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_product_category_prices', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_id');
            $table->string('series');
            $table->integer('column_number');
            // $table->double('price');
            $table->json('price_list')->default(json_encode([]));//nullable();

            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

            $table->softDeletes();

            $table->foreign('product_category_id')->references('id')->on('product_categories')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product_category_prices');
    }
}
