<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCesar20221010Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cesar_20221010', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->comment('Clave primaria');
			$table->string('placa', 6)->comment('numero placa');
			$table->bigInteger('documento1')->comment('documento 1');
			$table->bigInteger('documento2')->comment('documento 2');
			$table->string('nombre_propietario', 250)->nullable()->comment('nombre cliente');
			$table->string('tiene_telefono', 2)->nullable()->comment('tiene telefono');
			$table->integer('telefono1')->nullable();
			$table->integer('telefono2')->nullable();
			$table->integer('telefono3')->nullable();
			$table->integer('telefono4')->nullable();
			$table->string('tipo_documento', 3)->nullable();
			$table->string('anio', 4)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cesar_20221010');
	}

}
