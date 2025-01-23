<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataPeopleRelativesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_people_relatives', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_people_id')->nullable()->index('VALIDATA_PEOPLE_RELATIVES__VALIDATA_PEOPLE_ID_IDX');
			$table->string('document', 20)->index('VALIDATA_PEOPLE_RELATIVES__DOCUMENT_IDX');
			$table->string('last_name')->nullable();
			$table->string('surname')->nullable();
			$table->string('names')->nullable();
			$table->date('birth')->nullable();
			$table->enum('relation_type', array('HIJO','HERMANO','CONYUGE','CONCUBINO','NOIDENTIFICADO'))->default('NOIDENTIFICADO')->index('VALIDATA_PEOPLE_RELATIVES__RELATION_TYPE_IDX');
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
		Schema::drop('validata_people_relatives');
	}

}
