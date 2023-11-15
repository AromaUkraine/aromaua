<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('iso')->nullable()->comment('код валюты');
            $table->string('symbol')->nullable()->comment('Символ (знак) валюты');
            $table->string('html_code')->nullable();
            $table->string('unicode')->nullable();
            $table->boolean('active')->default(true);
            $table->string('type')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
