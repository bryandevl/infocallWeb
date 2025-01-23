<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpPagosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_pagos', function(Blueprint $table)
		{
			$table->string('cNUM_DOCUMENTO', 20)->primary();
			$table->decimal('PAGOS_MTO_3M', 10)->nullable();
			$table->decimal('PAGOS_MTO_6M', 10)->nullable();
			$table->decimal('PAGOS_MTO_12M', 10)->nullable();
			$table->integer('PAGOS_CTD_3M')->nullable();
			$table->integer('PAGOS_CTD_6M')->nullable();
			$table->integer('PAGOS_CTD_12M')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tmp_pagos');
	}

}
