<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('document', 20)->unique();
			$table->string('last_name')->nullable();
			$table->string('surname')->nullable();
			$table->string('names')->nullable();
			$table->string('turn_company', 500)->nullable()->index('IDX_VALIDATA_PEOPLE__TURN_COMPANY');
			$table->string('business_name', 500)->nullable()->index('IDX_VALIDATA_PEOPLE__BUSINESS_NAME');
			$table->date('birth')->nullable();
			$table->string('birth_place')->nullable();
			$table->enum('sex', array('MASCULINO','FEMENINO','EMPRESA'))->nullable();
			$table->enum('marital_status', array('SOLTERO','CASADO','CONVIVIENTE','VIUDO','NOIDENTIFICADO','DIVORCIADO'))->default('NOIDENTIFICADO');
			$table->string('status_company', 200)->nullable()->index('IDX_VALIDATA_PEOPLE__STATUS_COMPANY');
			$table->string('father_name')->nullable();
			$table->string('mother_name')->nullable();
			$table->string('ubigee', 20)->nullable()->index('IDX_VALIDATA_PEOPLE__UBIGEE');
			$table->string('address', 500)->nullable()->index('IDX_VALIDATA_PEOPLE__ADDRESS');
			$table->string('department', 200)->nullable()->index('IDX_VALIDATA_PEOPLE__DEPARTMENT');
			$table->string('province', 200)->nullable()->index('IDX_VALIDATA_PEOPLE__PROVINCE');
			$table->string('district', 200)->nullable()->index('IDX_VALIDATA_PEOPLE__DISTRICT');
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
		Schema::drop('validata_people');
	}

}
