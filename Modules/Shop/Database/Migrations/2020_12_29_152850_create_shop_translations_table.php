<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('shop_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->text('info')->nullable();
            $table->string('schedule')->nullable();
            $table->boolean('publish')->default(false);

            $table->timestamps();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_translations');
    }
}
