<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfocallSourceCron202012122213Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('infocall_source_cron_202012122213', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
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
		Schema::drop('infocall_source_cron_202012122213');
	}

}
