<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaSbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persona_sbs', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('persona_id')->nullable();
			$table->string('documento', 20);
			$table->string('cod_sbs', 20)->nullable();
			$table->date('fecha_reporte_sbs')->nullable();
			$table->string('ruc', 11)->nullable();
			$table->integer('cant_empresas')->nullable();
			$table->decimal('calificacion_normal', 5)->nullable()->default(0.00);
			$table->decimal('calificacion_cpp', 5)->nullable()->default(0.00);
			$table->decimal('calificacion_deficiente', 5)->nullable()->default(0.00);
			$table->decimal('calificacion_dudoso', 5)->nullable()->default(0.00);
			$table->decimal('calificacion_perdida', 5)->nullable()->default(0.00);
			$table->dateTime('fec_cron')->nullable();
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
		Schema::drop('persona_sbs');
	}

}
