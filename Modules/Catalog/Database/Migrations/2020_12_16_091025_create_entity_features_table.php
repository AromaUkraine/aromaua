<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntityFeaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entity_features', function (Blueprint $table) {
            $table->id();
            $table->string('entityable_type');
            $table->unsignedBigInteger('entityable_id');
            $table->unsignedBigInteger('feature_id')->nullable();
            $table->unsignedBigInteger('feature_kind_id')->nullable();
            $table->unsignedBigInteger('feature_value_id')->nullable();
            $table->decimal('value',12,2)->default(0);
            $table->decimal('value_from',12,2)->default(0);
            $table->decimal('value_to',12,2)->default(0);
            $table->boolean('modify_feature')->default(false);
            $table->boolean('modify_value')->default(false);

//            $table->softDeletes();
//            $table->timestamps();
            $table->foreign('feature_id')->references('id')->on('features')->onDelete('cascade');
            $table->foreign('feature_kind_id')->references('id')->on('feature_kinds')->onDelete('cascade');
            $table->foreign('feature_value_id')->references('id')->on('feature_values')->onDelete('cascade');

            $table->index(['entityable_type', 'entityable_id'], 'entityable_index_columns');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entity_features');
    }
}
