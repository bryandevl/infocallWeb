<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleVehicleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_vehicle', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__VALIDATA_PEOPLE_ID');
			$table->string('license_plate')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__LICENSE_PLATE');
			$table->string('brand')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__BRAND');
			$table->string('model')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__MODEL');
			$table->string('class')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__CLASS');
			$table->string('manufacturing', 4)->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__MANUFACTURING');
			$table->string('purchase')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__PURCHASE');
			$table->string('transfer_number')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__TRANSFER_NUMBER');
			$table->string('type')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__TYPE');
			$table->string('document_two', 12)->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__DOCUMENT_TWO');
			$table->string('fullname_two', 500)->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__FULLNAME_TWO');
			$table->string('property_type')->nullable()->index('IDX_VALIDATA_PEOPLE_VEHICLE__PROPERTY_TYPE');
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
		Schema::drop('validata_people_vehicle');
	}

}
