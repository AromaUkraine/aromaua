<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('gallery_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->text('alt')->nullable();
            $table->boolean('publish')->default(true);
            $table->timestamps();
            $table->foreign('gallery_id')->references('id')->on('galleries')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gallery_translations');
    }
}
