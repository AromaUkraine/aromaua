<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permission_id')->nullable();
            $table->unsignedBigInteger('page_id')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('active')->default(true);
            $table->nestedSet();
            $table->string('type')->nullable();;
            $table->json('data')->default('');
            $table->string('from')->default('backend');
            $table->softDeletes();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
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
        Schema::dropIfExists('menus');
    }
}
