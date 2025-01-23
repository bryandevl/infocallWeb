<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampaniaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campania', function(Blueprint $table)
		{
			$table->foreign('idcliente', 'fk_campania_idcliente')->references('idcliente')->on('cliente')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('idtramo', 'fk_campania_idtramo')->references('idtramo')->on('tramo')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campania', function(Blueprint $table)
		{
			$table->dropForeign('fk_campania_idcliente');
			$table->dropForeign('fk_campania_idtramo');
		});
	}

}
