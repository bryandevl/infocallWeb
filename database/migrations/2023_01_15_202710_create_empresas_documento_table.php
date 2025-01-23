<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasDocumentoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresas_documento', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('documento', 12)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__DOCUMENTO');
			$table->string('ruc', 20)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__RUC');
			$table->string('razonsocial', 500)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__RAZONSOCIAL');
			$table->string('nombrecomercial', 500)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__NOMBRECOMERCIAL');
			$table->string('tipo')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__TIPO');
			$table->date('fecha_inscripcion')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__FECHA_INSCRIPCION');
			$table->string('estado')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__ESTADO');
			$table->date('fecha_baja')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__FECHA_BAJA');
			$table->string('condicion', 200)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__CONDICION');
			$table->string('giro')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__GIRO');
			$table->string('ubigeo')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__UBIGEO');
			$table->string('direccion', 500)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__DIRECCION');
			$table->string('distrito')->nullable()->index('IDX_EMPRESAS_DOCUMENTO__DISTRITO');
			$table->string('provincia', 500)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__PROVINCIA');
			$table->string('departamento', 500)->nullable()->index('IDX_EMPRESAS_DOCUMENTO__DEPARTMENTO');
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
		Schema::drop('empresas_documento');
	}

}
