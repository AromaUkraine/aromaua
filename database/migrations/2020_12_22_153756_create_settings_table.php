<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('название');
            $table->string('key')->unique()->comment('уникальный ключ');
            $table->string('component')->comment('имя компонента который будем использовать');
            $table->string('group')->nullable()->comment('группировка элементов настроек');
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
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('settings');
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
