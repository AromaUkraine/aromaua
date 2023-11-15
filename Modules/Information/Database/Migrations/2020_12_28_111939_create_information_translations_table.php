<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('information_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('information_id')->unsigned();
            $table->string('locale', 3)->index();

            $table->string('title')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->text('text')->nullable();

            $table->boolean('publish')->default(true);
            $table->timestamps();
            $table->foreign('information_id')->references('id')->on('information')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('information_translations');
    }
}
