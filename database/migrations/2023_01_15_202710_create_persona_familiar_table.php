<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaFamiliarTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persona_familiar', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('persona_id')->nullable();
			$table->string('documento', 20)->index('IDX_DOCUMENTO');
			$table->string('documento_familiar', 20);
			$table->string('ape_paterno', 100);
			$table->string('ape_materno', 100)->nullable();
			$table->string('nombres', 100)->nullable();
			$table->date('fec_nacimiento')->nullable();
			$table->enum('tipo', array('HERMANO','CONYUGE','OTRO','HIJO','CONCUBINO'))->nullable();
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
		Schema::drop('persona_familiar');
	}

}
