<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTelefonoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persona_telefono', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('persona_id')->nullable();
			$table->string('documento', 20);
			$table->string('telefono', 15)->nullable();
			$table->enum('tipo_telefono', array('CELULAR','FIJO'))->nullable();
			$table->enum('tipo_operadora', array('MOVISTAR','CLARO','ENTEL','BITEL','OTRO'))->nullable();
			$table->string('origen_data', 100)->nullable();
			$table->date('fec_data')->nullable();
			$table->string('plan', 100)->nullable();
			$table->date('fec_activacion')->nullable();
			$table->string('modelo_celular', 100)->nullable();
			$table->dateTime('fec_cron')->nullable();
			$table->timestamps(10);
			$table->softDeletes();
			$table->string('user_created_at', 80)->nullable();
			$table->string('user_updated_at', 80)->nullable();
			$table->string('user_deleted_at', 80)->nullable();
			$table->integer('userid_created_at')->nullable();
			$table->integer('userid_updated_at')->nullable();
			$table->integer('userid_deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('persona_telefono');
	}

}
