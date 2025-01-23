<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReniec2018Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reniec_2018', function(Blueprint $table)
		{
			$table->integer('documento')->primary();
			$table->string('apellido_pat', 45)->nullable()->index();
			$table->string('apellido_mat', 45)->nullable()->index();
			$table->string('nombre', 60)->nullable();
			$table->string('fec_nac', 10)->nullable();
			$table->string('ubigeo', 6)->nullable()->index();
			$table->text('ubigeo_dir')->nullable();
			$table->text('direccion')->nullable();
			$table->integer('sexo')->nullable();
			$table->string('edo_civil', 10)->nullable();
			$table->integer('dig_ruc')->nullable();
			$table->string('nombre_mad', 45)->nullable()->index();
			$table->string('nombre_pat', 45)->nullable()->index();
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
		Schema::drop('reniec_2018');
	}

}
