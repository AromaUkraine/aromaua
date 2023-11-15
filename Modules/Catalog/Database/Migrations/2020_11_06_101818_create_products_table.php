<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('parent_product_id')->nullable();
            $table->unsignedBigInteger('product_category_id');

            $table->string('vendor_code')->nullable();
            $table->string('product_code')->nullable();
            $table->unsignedBigInteger('quantity_in_stock')->default(0);
            $table->string('status')->nullable();
            $table->integer('order')->default(0);
            $table->softDeletes();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')->onDelete('cascade');

            $table->foreign('parent_product_id')
                ->references('id')
                ->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
