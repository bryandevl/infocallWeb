<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceLogTableDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('source_log_table_detail', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('source_log_table_id')->nullable();
			$table->string('documento', 20)->nullable();
			$table->integer('total')->nullable()->default(0);
			$table->integer('total_new')->nullable()->default(0);
			$table->integer('total_update')->nullable()->default(0);
			$table->integer('total_delete')->nullable()->default(0);
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
		Schema::drop('source_log_table_detail');
	}

}
