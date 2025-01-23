<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaRepresentantesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa_representantes', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('tipo_documento')->nullable()->index('IDX_EMPRESA_REPRESENTANTES__TIPO_DOCUMENTO');
			$table->string('documento', 12)->nullable()->index('IDX_EMPRESA_REPRESENTANTES__DOCUMENTO');
			$table->string('ruc', 20)->nullable()->index('IDX_EMPRESA_REPRESENTANTES__RUC');
			$table->string('nombres', 500)->nullable()->index('IDX_EMPRESA_REPRESENTANTES__NOMBRES');
			$table->string('cargo', 50)->nullable()->index('IDX_EMPRESA_REPRESENTANTES__CARGO');
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
		Schema::drop('empresa_representantes');
	}

}
