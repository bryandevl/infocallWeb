<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCompaniaGrupoGestorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('compania_grupo_gestor', function(Blueprint $table)
		{
			$table->foreign('idcompania_grupo', 'fk_compania_grupo_gestor_idcompania_grupo')->references('idcampania_grupo')->on('campania_grupo')->onUpdate('NO ACTION')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('compania_grupo_gestor', function(Blueprint $table)
		{
			$table->dropForeign('fk_compania_grupo_gestor_idcompania_grupo');
		});
	}

}
