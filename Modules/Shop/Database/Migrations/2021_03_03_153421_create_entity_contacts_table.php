<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_contacts', function (Blueprint $table) {
            $table->id();
            $table->morphs('contactable');
            $table->string('value')->nullable();
            $table->string('type');
            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

            $table->softDeletes();

            $table->index(['contactable_type', 'contactable_id'], 'contactable_index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_contacts');
    }
}
