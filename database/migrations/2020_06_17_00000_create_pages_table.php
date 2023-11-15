<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pageable_id');
            $table->string('pageable_type');
            $table->string('method')->nullable();
            $table->string('controller')->nullable();
            $table->string('action')->nullable();
            $table->json('data')->default('');
            $table->boolean('active')->default(true);
            $table->softDeletes();

            $table->index(['pageable_type', 'pageable_id'], 'pageable_index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
