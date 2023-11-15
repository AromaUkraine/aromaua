<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            // связь со страницей (при использовании виджета)
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->unsignedBigInteger('page_component_id')->nullable();
            // связь с записью при привязке к записи
            $table->bigInteger('galleriable_id')->nullable();
            $table->string('galleriable_type')->nullable();

            $table->string('link')->nullable();
            $table->integer('order')->default(0);
            $table->enum('type',['photo','video']);
            $table->boolean('active')->default(true);
            $table->softDeletes();

            $table->foreign('parent_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('page_component_id')->references('id')->on('page_components')->onDelete('cascade');

            $table->index(['galleriable_type', 'galleriable_id'], 'galleriable__index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
}
