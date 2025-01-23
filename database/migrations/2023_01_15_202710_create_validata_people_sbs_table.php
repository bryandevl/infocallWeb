<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleSbsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_sbs', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('VALIDATA_PEOPLE_SBS__VALIDATA_PEOPLE_ID_IDX');
			$table->date('report_date')->nullable()->index('VALIDATA_PEOPLE_SBS__REPORT_DATE_IDX');
			$table->integer('company_quantity')->default(0);
			$table->decimal('normal_rating', 6)->default(0.00);
			$table->decimal('cpp_rating', 6)->default(0.00);
			$table->decimal('deficient_rating', 6)->default(0.00);
			$table->decimal('uncertain_rating', 6)->default(0.00);
			$table->decimal('lost_rating', 6)->default(0.00);
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
		Schema::drop('validata_people_sbs');
	}

}
