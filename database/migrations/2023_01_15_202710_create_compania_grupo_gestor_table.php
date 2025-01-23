<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniaGrupoGestorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('compania_grupo_gestor', function(Blueprint $table)
		{
			$table->integer('idcompania_grupo_gestor', true);
			$table->integer('idcompania_grupo')->index('fk_compania_grupo_gestor_idcompania_grupo_idx');
			$table->integer('iduser');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('compania_grupo_gestor');
	}

}
