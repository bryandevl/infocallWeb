<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpMontosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_montos', function(Blueprint $table)
		{
			$table->string('document', 20)->primary();
			$table->decimal('montoCNC', 14)->nullable();
			$table->bigInteger('cantidad')->nullable();
			$table->decimal('montoTotal', 36)->nullable();
			$table->bigInteger('days_late')->nullable();
			$table->decimal('saldo_cast', 37)->nullable();
			$table->decimal('castCSD_castTOT', 20, 6)->nullable();
			$table->decimal('castCSD_saldoRCC', 20, 6)->nullable();
			$table->decimal('castTOT_saldoRCC', 18, 6)->nullable();
			$table->decimal('cant_ent_CASTIGO_2', 37)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tmp_montos');
	}

}
