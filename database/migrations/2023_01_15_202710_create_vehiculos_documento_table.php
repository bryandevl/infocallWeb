<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiculosDocumentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehiculos_documento', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('documento', 12)->nullable()->index('IDX_VEHICULOS__DOCUMENTO');
			$table->string('placa')->nullable()->index('IDX_VEHICULOS__PLACA');
			$table->string('marca')->nullable()->index('IDX_VEHICULOS__MARCA');
			$table->string('modelo')->nullable()->index('IDX_VEHICULOS__MODELO');
			$table->string('clase')->nullable()->index('IDX_VEHICULOS__CLASE');
			$table->string('fabricacion', 4)->nullable()->index('IDX_VEHICULOS__FABRICACION');
			$table->string('compra')->nullable()->index('IDX_VEHICULOS__COMPRA');
			$table->string('numero_transferencia')->nullable()->index('IDX_VEHICULOS__NUMERO_TRANSFERENCIA');
			$table->string('tipo')->nullable()->index('IDX_VEHICULOS__TIPO');
			$table->string('segundo_documento', 12)->nullable()->index('IDX_VEHICULOS__SEGUNDO_DOCUMENTO');
			$table->string('segundo_nombrecompleto', 500)->nullable()->index('IDX_VEHICULOS__SEGUNDO_NOMBRECOMPLETO');
			$table->string('tipo_propiedad')->nullable()->index('IDX_VEHICULOS__TIPO_PROPIEDAD');
			$table->dateTime('validata_created_at')->nullable();
			$table->dateTime('validata_updated_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vehiculos_documento');
	}

}
