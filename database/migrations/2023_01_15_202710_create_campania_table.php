<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania', function(Blueprint $table)
		{
			$table->integer('idcampania', true);
			$table->integer('idcliente')->index('fk_campania_idcliente_idx');
			$table->integer('idtramo')->index('fk_campania_idtramo_idx');
			$table->string('nombre', 120)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania');
	}

}
