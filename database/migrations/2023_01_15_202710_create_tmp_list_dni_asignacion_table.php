<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpListDniAsignacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_list_dni_asignacion', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('cNUM_DOCUMENTO', 20)->nullable();
			$table->string('campaign_id', 20)->nullable();
			$table->string('status', 20)->nullable();
			$table->string('tmp_list_dni_asignacioncol', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tmp_list_dni_asignacion');
	}

}
