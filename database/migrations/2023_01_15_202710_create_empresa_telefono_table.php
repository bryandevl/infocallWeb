<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTelefonoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa_telefono', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('ruc', 20)->nullable()->index('IDX_EMPRESA_TELEFONO__TIPO_RUC');
			$table->string('razonsocial', 500)->nullable()->index('IDX_EMPRESA_TELEFONO__RAZONSOCIAL');
			$table->string('numero', 20)->nullable()->index('IDX_EMPRESA_TELEFONO__NUMERO');
			$table->string('tipo', 20)->nullable()->index('IDX_EMPRESA_TELEFONO__TIPO');
			$table->string('fuente', 20)->nullable()->index('IDX_EMPRESA_TELEFONO__FUENTE');
			$table->dateTime('validata_created_at')->nullable();
			$table->dateTime('validata_updated_at')->nullable();
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
		Schema::drop('empresa_telefono');
	}

}
