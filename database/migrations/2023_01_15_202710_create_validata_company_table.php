<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataCompanyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_company', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('id_number', 20)->nullable()->index('IDX_VALIDATA_COMPANY__ID_NUMBER');
			$table->string('business_name', 500)->nullable()->index('IDX_VALIDATA_COMPANY__BUSINESS_NAME');
			$table->string('tradename')->nullable()->index('IDX_VALIDATA_COMPANY__TRADENAME');
			$table->string('type')->nullable()->index('IDX_VALIDATA_COMPANY__TYPE');
			$table->date('registration_date')->nullable()->index('IDX_VALIDATA_COMPANY__REGISTRATION_DATE');
			$table->string('status')->nullable()->index('IDX_VALIDATA_COMPANY__STATUS');
			$table->date('down_date')->nullable()->index('IDX_VALIDATA_COMPANY__DOWN_DATE');
			$table->string('condition', 200)->nullable()->index('IDX_VALIDATA_COMPANY__CONDITION');
			$table->string('turn')->nullable()->index('IDX_VALIDATA_COMPANY__TURN');
			$table->string('ubigee')->nullable()->index('IDX_VALIDATA_COMPANY__UBIGEE');
			$table->string('address', 500)->nullable()->index('IDX_VALIDATA_COMPANY__ADDRESS');
			$table->string('district')->nullable()->index('IDX_VALIDATA_COMPANY__DISTRICT');
			$table->string('province', 500)->nullable()->index('IDX_VALIDATA_COMPANY__PROVINCE');
			$table->string('department', 500)->nullable()->index('IDX_VALIDATA_COMPANY__DEPARTMENT');
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
		Schema::drop('validata_company');
	}

}
