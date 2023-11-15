<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSynchronizeTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('synchronize_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('synchronize_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable()->comment('field Name from price_colums table in remote database');
            $table->timestamps();

            $table->foreign('synchronize_id')->references('id')->on('synchronizes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('synchronize_translations');
    }
}
