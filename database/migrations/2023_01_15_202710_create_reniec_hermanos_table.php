<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReniecHermanosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('reniec_hermanos', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->bigInteger('documento')->nullable()->index('idx_reniec_hermanos_documento');
			$table->bigInteger('doc_parent')->nullable()->index('idx_reniec_hermanos_doc_parent');
			$table->string('nombre', 120)->nullable();
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
		Schema::drop('reniec_hermanos');
	}

}
