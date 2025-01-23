<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaGrupoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania_grupo', function(Blueprint $table)
		{
			$table->integer('idcampania_grupo', true);
			$table->integer('idcampania_base')->index('fk_campania_grupo_idcampania_base_idx');
			$table->string('nombre', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania_grupo');
	}

}
