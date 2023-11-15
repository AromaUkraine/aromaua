<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageComponentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_components', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('page_id');
            $table->string('name')->comment('название модуля');
            $table->string('alias')->comment('уникальный ключ');
            $table->string('description')->nullable()->comment('описание работы модуля, что у него имеется');
            $table->string('type')->comment('тип модуля');
            $table->json('data')->default('')->comment('json данные');
            $table->integer('order')->default(0)->comment('сортировка');
            $table->boolean('active')->default(true)->comment('Включение/выключение модуля');
            $table->timestamps();
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_components');
    }
}
