<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('empresa', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('ruc', 11)->unique('IDX_documento');
			$table->string('razonsocial', 500)->nullable();
			$table->date('fec_cron')->nullable();
			$table->string('estado', 100)->nullable()->index('IDX_EMPRESA__ESTADO');
			$table->string('giro', 500)->nullable()->index('IDX_EMPRESA__GIRO');
			$table->string('ubigeo', 20)->nullable()->index('IDX_EMPRESA__UBIGEO');
			$table->string('distrito', 100)->nullable()->index('IDX_EMPRESA__DISTRITO');
			$table->string('departamento', 100)->nullable()->index('IDX_EMPRESA__DEPARTAMENTO');
			$table->string('provincia', 100)->nullable()->index('IDX_EMPRESA__PROVINCIA');
			$table->string('direccion', 500)->nullable()->index('IDX_EMPRESA__DIRECCION');
			$table->dateTime('validata_created_at')->nullable()->index('IDX_EMPRESA__VALIDATA_CREATED_AT');
			$table->dateTime('validata_updated_at')->nullable()->index('IDX_EMPRESA__VALIDATA_UPDATED_AT');
			$table->timestamps(10);
			$table->softDeletes();
			$table->string('user_created_at', 80)->nullable();
			$table->string('user_updated_at', 80)->nullable();
			$table->string('user_deleted_at', 80)->nullable();
			$table->integer('userid_created_at')->nullable();
			$table->integer('userid_updated_at')->nullable();
			$table->integer('userid_deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('empresa');
	}

}
