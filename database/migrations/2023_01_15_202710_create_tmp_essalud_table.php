<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpEssaludTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tmp_essalud', function(Blueprint $table)
		{
			$table->string('documento', 20);
			$table->integer('periodo');
			$table->decimal('sueldo', 18)->nullable();
			$table->primary(['documento','periodo']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tmp_essalud');
	}

}
