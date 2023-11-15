<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_kind_id');
            $table->boolean('filter')->default(false)->comment('показывать в фильтре');
            $table->boolean('preview')->default(false)->comment('показывать в превью товара');
            $table->boolean('page')->default(false)->comment('показывать на странице');
            $table->boolean('active')->default(true);
            $table->integer('order')->default(0);
            $table->softDeletes();

            $table->foreign('feature_kind_id')->references('id')->on('feature_kinds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features');
    }
}
