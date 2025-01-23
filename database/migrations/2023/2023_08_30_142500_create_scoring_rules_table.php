<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoringRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            "scoring_rules",
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string("campaign", 50)->nullable();
                $table->decimal("score1_min", 10, 3)->default(0.00);
                $table->decimal("score1_max", 10, 3)->default(0.00);
                $table->decimal("score2_min", 10, 3)->default(0.00);
                $table->decimal("score2_max", 10, 3)->default(0.00);
                $table->decimal("score3_min", 10, 3)->default(0.00);
                $table->decimal("score3_max", 10, 3)->default(0.00);
                $table->decimal("score4_min", 10, 3)->default(0.00);
                $table->decimal("score4_max", 10, 3)->default(0.00);
                $table->decimal("score5_min", 10, 3)->default(0.00);
                $table->decimal("score5_max", 10, 3)->default(0.00);

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
        Schema::dropIfExists('scoring_rules');
    }
}
