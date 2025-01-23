<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUbigeoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ubigeo', function(Blueprint $table)
		{
			$table->string('ubigeo', 6)->unique('ubigeo_ubigeo_uindex');
			$table->string('departamento', 45)->nullable();
			$table->string('provincia', 45)->nullable();
			$table->string('distrito', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ubigeo');
	}

}
