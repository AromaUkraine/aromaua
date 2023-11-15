<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDocumentTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_document_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_document_id');
            $table->string('locale', 3)->index();
            $table->string('name');
            $table->string('href');
            $table->string('date')->comment('поле data в json-файле содержащее дату');

            $table->boolean('publish')->default(true);
            $table->timestamps();

            $table->foreign('product_document_id')->references('id')->on('product_documents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_document_translations');
    }
}