<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReniecConyugesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reniec_conyuges', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->integer('documento')->index('idx_reniec_conyuges_documento');
			$table->integer('doc_parent')->index('idx_reniec_conyuges_doc_parent');
			$table->string('nombre', 120)->nullable();
			$table->string('parentezco', 20)->nullable();
			$table->dateTime('validata_created_at')->nullable();
			$table->dateTime('validata_updated_at')->nullable();
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
		Schema::drop('reniec_conyuges');
	}

}
