<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEssaludTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('essalud', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('documento')->nullable()->index();
			$table->string('empresa', 120)->nullable();
			$table->integer('periodo')->nullable();
			$table->bigInteger('ruc')->nullable();
			$table->string('condicion', 1)->nullable();
			$table->decimal('sueldo', 18)->nullable();
			$table->dateTime('validata_updated_at')->nullable();
			$table->dateTime('validata_created_at')->nullable();
			$table->timestamps(10);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('essalud');
	}

}
