<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaBaseGestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania_base_gestion', function(Blueprint $table)
		{
			$table->integer('idcampania_base_gestion', true);
			$table->integer('idcampania_base_registro')->index('fk_campania_base_gestion_idcampania_base_registro_idx');
			$table->dateTime('create_at')->nullable();
			$table->dateTime('update_at')->nullable();
			$table->text('comentario')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania_base_gestion');
	}

}
