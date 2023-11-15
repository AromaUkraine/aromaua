<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityContactTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_contact_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('entity_contact_id')->unsigned();
            $table->string('locale', 3)->index();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->boolean('publish')->default(true);
            $table->timestamps();

            $table->foreign('entity_contact_id')->references('id')->on('entity_contacts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_contact_translations');
    }
}
