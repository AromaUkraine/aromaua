<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeatureKindTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_kind_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('feature_kind_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable();
            $table->boolean('publish')->default(false);
            $table->timestamps();
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
        Schema::dropIfExists('feature_kind_translations');
    }
}
