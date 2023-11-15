<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureValueTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_value_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('feature_value_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable();
            $table->boolean('publish')->default(false);
            $table->timestamps();
            $table->foreign('feature_value_id')->references('id')->on('feature_values')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feature_value_translations');
    }
}
