<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleRepresentativeTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_representative', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__VALIDATA_PEOPLE_ID');
			$table->string('document_type', 20)->nullable()->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__DOCUMENT_TYPE');
			$table->string('document', 20)->nullable()->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__DOCUMENT');
			$table->string('fullname', 500)->nullable()->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__FULLNAME');
			$table->string('turn')->nullable()->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__TURN');
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
		Schema::drop('validata_people_representative');
	}

}
