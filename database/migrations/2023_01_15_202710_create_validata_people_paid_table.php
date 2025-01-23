<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeoplePaidTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_paid', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('numcuenta', 45)->nullable();
			$table->string('numdocumento', 45)->nullable();
			$table->dateTime('fechapago')->nullable();
			$table->decimal('monto', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('validata_people_paid');
	}

}
