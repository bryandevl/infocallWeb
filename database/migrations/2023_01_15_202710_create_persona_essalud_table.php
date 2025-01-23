<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaEssaludTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('persona_essalud', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('persona_id')->nullable();
			$table->string('documento', 25)->index('IDX_DOCUMENTO');
			$table->string('periodo', 6)->nullable();
			$table->bigInteger('empresa_id')->nullable();
			$table->decimal('sueldo', 10)->nullable()->default(0.00);
			$table->string('situacion', 2)->nullable();
			$table->date('fec_cron')->nullable();
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
		Schema::drop('persona_essalud');
	}

}
