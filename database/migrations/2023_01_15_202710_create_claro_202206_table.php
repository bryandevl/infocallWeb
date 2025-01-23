<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaro202206Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('claro_202206', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('categoria', 30)->nullable();
			$table->integer('telefono')->unique('IDX_Telefono');
			$table->string('tipDocumento', 20)->nullable();
			$table->bigInteger('documento')->nullable();
			$table->string('nombres', 250)->nullable();
			$table->string('apellidos', 250)->nullable();
			$table->string('correo', 250)->nullable();
			$table->string('departamento', 50)->nullable();
			$table->string('provincia', 50)->nullable();
			$table->string('distrito', 50)->nullable();
			$table->string('plan', 250)->nullable();
			$table->integer('ciclo')->nullable();
			$table->string('trafico', 10)->nullable();
			$table->dateTime('fechaAct')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('claro_202206');
	}

}
