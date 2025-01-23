<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfocallSourceCron202012122240Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('infocall_source_cron_202012122240', function(Blueprint $table)
		{
			$table->bigInteger('id')->unsigned()->default(0);
			$table->string('num_documento', 12)->nullable();
			$table->timestamps(10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('infocall_source_cron_202012122240');
	}

}
