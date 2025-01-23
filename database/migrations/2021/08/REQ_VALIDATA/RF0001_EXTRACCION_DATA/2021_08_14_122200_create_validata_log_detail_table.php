<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataLogDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_log_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_log_id');
            $table->string('document', 20)->nullable();
            $table->enum('status', ['REGISTER', 'PROCESS', 'FAILED']);
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('user_created_at', 80)->nullable();
            $table->string('user_updated_at', 80)->nullable();
            $table->string('user_deleted_at', 80)->nullable();
            $table->integer('userid_created_at')->nullable();
            $table->integer('userid_updated_at')->nullable();
            $table->integer('userid_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validata_log_detail');
    }
}
