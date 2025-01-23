<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleSbsDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_sbs_detail', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_sbs_id')->nullable()->index('VALIDATA_PEOPLE_SBS_DETAIL__VALIDATA_PEOPLE_SBS_ID_IDX');
			$table->string('entity', 500)->nullable()->index('VALIDATA_PEOPLE_SBS_DETAIL__ENTITY_IDX');
			$table->enum('credit_type', array('TARJETA','PRESTAMO','HIPOTECARIO','VEHICULAR','COMERCIAL','CONVENIO','OTROS'))->nullable()->index('VALIDATA_PEOPLE_SBS_DETAIL__CREDIT_TYPE_IDX');
			$table->string('credit_type_detail')->nullable()->index('VALIDATA_PEOPLE_SBS_DETAIL__CREDIT_TYPE_DETAIL_IDX');
			$table->decimal('amount', 14)->default(0.00)->index('VALIDATA_PEOPLE_SBS_DETAIL__AMOUNT_IDX');
			$table->integer('days_late')->default(0);
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
		Schema::drop('validata_people_sbs_detail');
	}

}
