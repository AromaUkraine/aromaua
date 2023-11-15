<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCode1cFeatureFeatureValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->string('code_1c')->after('page')->nullable();
            $table->index('code_1c');
        });
        Schema::table('feature_values', function (Blueprint $table) {
            $table->string('code_1c')->after('feature_kind_id')->nullable();
            $table->index('code_1c');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropColumn('code_1c');
        });
        Schema::table('feature_values', function (Blueprint $table) {
            $table->dropColumn('code_1c');
        });
    }
}
