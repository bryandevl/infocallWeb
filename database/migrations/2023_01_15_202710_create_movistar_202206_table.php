<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovistar202206Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movistar_202206', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('telefono')->unique('IDX_Telefono');
			$table->string('categoria', 30)->nullable();
			$table->date('fechaAct')->nullable();
			$table->string('tipDocumento', 20)->nullable();
			$table->bigInteger('documento')->nullable()->index('IDX_documento');
			$table->string('nombres', 250)->nullable();
			$table->string('apellidos', 250)->nullable();
			$table->string('correo', 250)->nullable();
			$table->string('estado', 20)->nullable();
			$table->string('rut_id', 10)->nullable();
			$table->string('nombreLegal', 250)->nullable();
			$table->string('pais', 20)->nullable();
			$table->string('departamento', 20)->nullable();
			$table->string('provincia', 20)->nullable();
			$table->string('distrito', 20)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('movistar_202206');
	}

}
