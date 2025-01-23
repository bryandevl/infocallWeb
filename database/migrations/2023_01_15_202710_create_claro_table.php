<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClaroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('claro', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('documento')->index('idx_claro_documento');
			$table->string('nombre', 120)->nullable();
			$table->integer('numero')->index('idx_claro_numero');
			$table->string('origen_data', 100)->nullable()->index('IDX_CLARO__ORIGEN_DATA');
			$table->date('fecha_data')->nullable()->index('IDX_CLARO__FECHA_DATA');
			$table->string('plan', 200)->nullable()->index('IDX_CLARO__PLAN');
			$table->date('fecha_activacion')->nullable()->index('IDX_CLARO__FECHA_ACTIVACION');
			$table->string('modelo', 200)->nullable()->index('IDX_CLARO__MODELO');
			$table->dateTime('validata_updated_at')->nullable();
			$table->dateTime('validata_created_at')->nullable();
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
		Schema::drop('claro');
	}

}
