<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataLogDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_log_detail', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_log_id')->index('validata_log_detail__validata_log_id_IDX');
			$table->string('document', 20)->nullable()->index('validata_log_detail__document_IDX');
			$table->string('campaign_id', 10)->nullable();
			$table->string('period', 10)->nullable()->index('validata_log_detail__period_IDX');
			$table->enum('status', array('FAILED','NOTDATA','ONQUEUE','PROCESS','REGISTER','REPEAT'))->nullable()->index('validata_log_detail__status_IDX');
			$table->string('job_id')->nullable();
			$table->dateTime('time_start')->nullable();
			$table->dateTime('time_end')->nullable();
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
		Schema::drop('validata_log_detail');
	}

}
