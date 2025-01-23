<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCampaniaBaseTelefonosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('campania_base_telefonos', function(Blueprint $table)
		{
			$table->foreign('idcampania_base_registro', 'fk_campania_base_telefonos_idcampania_base_registro')->references('idcampania_base_registro')->on('campania_base_registro')->onUpdate('NO ACTION')->onDelete('CASCADE');
			$table->foreign('idtelefono_operadora', 'fk_campania_base_telefonos_idtelefono_operadora')->references('idtelefono_operadora')->on('telefono_operadora')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('campania_base_telefonos', function(Blueprint $table)
		{
			$table->dropForeign('fk_campania_base_telefonos_idcampania_base_registro');
			$table->dropForeign('fk_campania_base_telefonos_idtelefono_operadora');
		});
	}

}
