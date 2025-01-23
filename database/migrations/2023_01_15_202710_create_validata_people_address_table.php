<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_address', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('VALIDATA_PEOPLE_ADDRESS__VALIDATA_PEOPLE_ID_IDX');
			$table->string('ubigeo', 10)->nullable()->index('VALIDATA_PEOPLE_ADDRESS__UBIGEO_IDX');
			$table->string('ubigeo_description')->nullable();
			$table->string('address')->nullable();
			$table->string('source')->nullable()->index('VALIDATA_PEOPLE_ADDRESS__SOURCE_IDX');
			$table->date('source_date')->nullable();
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
		Schema::drop('validata_people_address');
	}

}
