<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReniecFamiliaresTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reniec_familiares', function(Blueprint $table)
		{
			$table->integer('documento')->nullable()->index();
			$table->integer('doc_parent')->nullable()->index();
			$table->string('nombre', 120)->nullable();
			$table->enum('tipo', array('PADRE','MADRE','HIJO'))->nullable();
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
		Schema::drop('reniec_familiares');
	}

}
