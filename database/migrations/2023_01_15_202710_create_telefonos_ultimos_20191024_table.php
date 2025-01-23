<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTelefonosUltimos20191024Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('telefonos_ultimos_20191024', function(Blueprint $table)
		{
			$table->integer('documento');
			$table->integer('numero');
			$table->string('descripcion', 200)->nullable();
			$table->integer('procesado')->nullable();
			$table->primary(['documento','numero']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('telefonos_ultimos_20191024');
	}

}
