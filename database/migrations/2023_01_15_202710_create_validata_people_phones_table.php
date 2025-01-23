<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeoplePhonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_phones', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('VALIDATA_PEOPLE_PHONES__VALIDATA_PEOPLE_ID_IDX');
			$table->string('phone')->nullable()->index('VALIDATA_PEOPLE_PHONES__PHONE_IDX');
			$table->string('plan')->nullable();
			$table->string('phone_model')->nullable();
			$table->date('source_date')->nullable();
			$table->enum('phone_type', array('FIJO','CELULAR','NOIDENTIFICADO'))->default('NOIDENTIFICADO')->index('VALIDATA_PEOPLE_PHONES__PHONE_TYPE_IDX');
			$table->string('source_data', 500)->default('NOIDENTIFICADO');
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
		Schema::drop('validata_people_phones');
	}

}
