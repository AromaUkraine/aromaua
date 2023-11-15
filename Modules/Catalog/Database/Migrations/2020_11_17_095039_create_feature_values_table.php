<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('feature_kind_id');
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
        Schema::dropIfExists('feature_values');
    }
}
