<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('settings_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->unique(['settings_id', 'locale']);
            $table->string('default')->nullable()->comment('значение по умолчанию');
            $table->string('value')->nullable()->comment('значение измененное');

            $table->timestamps();
            $table->foreign('settings_id')->references('id')->on('settings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         Schema::dropIfExists('settings_translations');
    }
}
