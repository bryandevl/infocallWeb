<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpAsignacionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_asignacion', function(Blueprint $table)
		{
			$table->string('cNUM_DOCUMENTO', 20)->primary();
			$table->string('cANO_CASTIGO', 20)->nullable();
			$table->decimal('nMON_CANCELA_TOT', 10, 0)->nullable();
			$table->integer('Peso_Estado')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tmp_asignacion');
	}

}
