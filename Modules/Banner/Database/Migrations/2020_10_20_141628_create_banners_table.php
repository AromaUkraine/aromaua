<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->unsignedBigInteger('page_component_id')->nullable();

            $table->string('bannerable_type')->nullable();
            $table->bigInteger('bannerable_id')->nullable();

            $table->integer('order')->default(0)->comment('сортировка');
            $table->boolean('active')->default(true);
            $table->softDeletes();

            $table->foreign('parent_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('page_component_id')->references('id')->on('page_components')->onDelete('cascade');

            $table->index(['bannerable_type', 'bannerable_id'], 'bannerable_index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
}
