<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoCatalogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_catalogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->boolean('is_brand')->default(false);
            $table->integer('order')->default(0);
            $table->unsignedBigInteger('country_id')->nullable()->comment('id из таблицы feature_values где key в таблице feature_kind равен country');

            $table->softDeletes();

            $table->foreign('product_category_id')
                ->references('id')
                ->on('product_categories')->onDelete('set null');

            $table->foreign('country_id')
                ->references('id')
                ->on('feature_values')->onDelete('set null');

            $table->foreign('parent_page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seo_catalogs');
    }
}
