<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('page_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name');
            $table->string('slug')->comment('url-страницы');
            $table->text('description')->nullable();
            $table->text('text')->nullable();

            $table->string('h1')->nullable();
            $table->string('title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('breadcrumbs')->nullable();
            $table->string('anchor')->nullable();

            $table->boolean('publish')->default(false);
            $table->timestamps();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_translations');
    }
}
