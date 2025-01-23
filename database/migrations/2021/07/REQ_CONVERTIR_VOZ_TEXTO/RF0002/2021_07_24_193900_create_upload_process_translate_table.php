<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadProcessTranslateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('upload_process_translate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('finance_entity_id')->nullable();
            $table->date('date_upload')->nullable();
            $table->dateTime('date_start_process')->nullable();
            $table->dateTime('date_finish_process')->nullable();
            $table->integer('total_files')->default(0);
            $table->integer('total_files_process')->default(0);
            $table->integer('total_files_failed')->default(0);
            $table->string('email_notification', 255)->nullable();
            $table->string('comment', 255)->nullable();
            $table->boolean('is_process')->default(false);
            $table->boolean('sending_email_notification')->default(false);

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
        Schema::dropIfExists('create_upload_process_translate');
    }
}
