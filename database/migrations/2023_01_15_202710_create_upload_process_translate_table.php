<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadProcessTranslateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('upload_process_translate', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('finance_entity_id')->nullable();
			$table->date('date_upload')->nullable();
			$table->dateTime('date_start_process')->nullable();
			$table->dateTime('date_finish_process')->nullable();
			$table->integer('total_files')->default(0);
			$table->integer('total_files_process')->default(0);
			$table->integer('total_files_failed')->default(0);
			$table->string('email_notification')->nullable();
			$table->string('translate_path', 191)->nullable();
			$table->string('comment')->nullable();
			$table->boolean('is_process')->default(0);
			$table->boolean('sending_email_notification')->default(0);
			$table->timestamps(10);
			$table->softDeletes();
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
		Schema::drop('upload_process_translate');
	}

}
