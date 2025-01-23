<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadCorreoDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_correo_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('upload_correo_id')->nullable();
            $table->string('file_path', 500)->nullable();
            $table->enum('process_status', ['REGISTER', 'PROCESS', 'FAILED'])->default("REGISTER");

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
        Schema::dropIfExists('upload_correo_detail');
    }
}
