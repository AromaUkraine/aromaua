<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSerialNumberToProductDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_documents', function (Blueprint $table) {
            $table
                ->unsignedInteger('serial_number')
                ->nullable()
                ->after('column_number')
                ->comment('Порядковый номер документа');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_documents', function (Blueprint $table) {

        });
    }
}
