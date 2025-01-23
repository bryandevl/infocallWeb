<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampaniaBaseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campania_base', function(Blueprint $table)
		{
			$table->foreign('idcampania', 'fk_campania_base_idcampania')->references('idcampania')->on('campania')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campania_base', function(Blueprint $table)
		{
			$table->dropForeign('fk_campania_base_idcampania');
		});
	}

}
