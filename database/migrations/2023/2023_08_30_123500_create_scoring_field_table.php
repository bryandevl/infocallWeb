<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoringFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            "scoring_field",
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string("campaign", 50)->nullable();
                $table->string("database", 100)->nullable();
                $table->string("tableName", 100)->nullable();
                $table->string("field", 100)->nullable();
                $table->string("condition", 5)->nullable();
                $table->string("value_condition", 10)->nullable();
                $table->integer("value_score")->default(0);

                $table->dateTime('created_at')->nullable();
                $table->dateTime('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('user_created_at', 80)->nullable();
                $table->string('user_updated_at', 80)->nullable();
                $table->string('user_deleted_at', 80)->nullable();
                $table->integer('userid_created_at')->nullable();
                $table->integer('userid_updated_at')->nullable();
                $table->integer('userid_deleted_at')->nullable();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scoring_field');
    }
}
