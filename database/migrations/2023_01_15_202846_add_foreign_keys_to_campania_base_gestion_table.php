<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampaniaBaseGestionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campania_base_gestion', function(Blueprint $table)
		{
			$table->foreign('idcampania_base_registro', 'fk_campania_base_gestion_idcampania_base_registro')->references('idcampania_base_registro')->on('campania_base_registro')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campania_base_gestion', function(Blueprint $table)
		{
			$table->dropForeign('fk_campania_base_gestion_idcampania_base_registro');
		});
	}

}
