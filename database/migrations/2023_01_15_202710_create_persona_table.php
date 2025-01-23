<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persona', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('documento', 20)->nullable()->unique('documento_UNIQUE');
			$table->string('ape_paterno', 100)->nullable();
			$table->string('ape_materno', 100)->nullable();
			$table->string('nombres', 100)->nullable();
			$table->date('fec_nacimiento')->nullable();
			$table->string('ubigeo_nacimiento', 6)->nullable();
			$table->string('padre_nombres', 100)->nullable();
			$table->string('madre_nombres', 100)->nullable();
			$table->enum('estado_civil', array('SOLTERO','CASADO','VIUDO','DIVORCIADO'))->nullable();
			$table->boolean('sexo')->nullable();
			$table->string('direccion', 300)->nullable();
			$table->string('ubigeo_direccion', 300)->nullable();
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
		Schema::drop('persona');
	}

}
