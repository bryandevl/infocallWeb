<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampaniaBaseRegistroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campania_base_registro', function(Blueprint $table)
		{
			$table->foreign('idcampania_base', 'fk_campania_base_registro_idcampania_base')->references('idcampania_base')->on('campania_base')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campania_base_registro', function(Blueprint $table)
		{
			$table->dropForeign('fk_campania_base_registro_idcampania_base');
		});
	}

}
