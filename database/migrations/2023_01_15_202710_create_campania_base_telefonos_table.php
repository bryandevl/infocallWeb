<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaBaseTelefonosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania_base_telefonos', function(Blueprint $table)
		{
			$table->integer('idcampania_base_telefonos', true);
			$table->integer('idcampania_base_registro')->index('fk_campania_base_telefonos_idcampania_base_registro_idx');
			$table->integer('idtelefono_operadora')->index('fk_campania_base_telefonos_idtelefono_operadora_idx');
			$table->integer('numero')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania_base_telefonos');
	}

}
