<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldKodKartochkiNomenklatureToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('code_1c')
                ->index('product_code_1c')
                ->after('order')
                ->comment('field kod_kartochki_price in remote database');

            $table->string('code')
                ->index('product_code')
                ->after('code_1c')
                ->comment('field kod in remote database');

            $table->json('data')
                ->nullable()
                ->after('code')
                ->comment('all data from remote database in json format');

            $table->index('vendor_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('code_1c');
            $table->dropColumn('code');
            $table->dropColumn('data');
        });
    }
}
