<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information', function (Blueprint $table) {
            $table->id();

            // связь со страницей (при использовании виджета)
            $table->unsignedBigInteger('parent_page_id')->nullable();
            $table->unsignedBigInteger('page_component_id')->nullable();
            // связь с записью при привязке к записи
            $table->bigInteger('informable_id')->nullable();
            $table->string('informable_type')->nullable();

            $table->unsignedBigInteger('parent_information_id')->nullable();
            $table->string('type')->nullable();
            $table->string('icon')->nullable();

            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

            $table->softDeletes();

            $table->foreign('parent_page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('page_component_id')->references('id')->on('page_components')->onDelete('cascade');

            $table->foreign('parent_information_id')->references('id')->on('information')->onDelete('cascade');

            $table->index(['informable_id', 'informable_type'], 'information_index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information');
    }
}
