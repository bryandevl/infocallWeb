<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaBaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania_base', function(Blueprint $table)
		{
			$table->integer('idcampania_base', true);
			$table->integer('idcampania')->index('fk_campania_base_idcampania_idx');
			$table->string('nombre', 45)->nullable();
			$table->integer('iduser')->nullable();
			$table->dateTime('create_at')->nullable();
			$table->dateTime('update_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania_base');
	}

}
