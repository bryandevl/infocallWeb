<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleEssaludTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_essalud', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('VALIDATA_PEOPLE_ESSALUD__PEOPLE_ID_IDX');
			$table->string('period', 6)->nullable()->index('VALIDATA_PEOPLE_ESSALUD__PERIOD_IDX');
			$table->string('ruc', 11)->nullable()->index('VALIDATA_PEOPLE_ESSALUD__RUC_IDX');
			$table->string('company_name', 500)->nullable();
			$table->decimal('salary', 14)->default(0.00);
			$table->string('situation')->nullable();
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
		Schema::drop('validata_people_essalud');
	}

}
