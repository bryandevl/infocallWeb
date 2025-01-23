<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidataLogDetailSourceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('validata_log_detail_source', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->bigInteger('validata_log_detail_id')->nullable()->index('validata_log_detail_source__validata_log_detail_id_IDX');
			$table->string('document', 20)->nullable()->index('validata_log_detail_source__document_IDX');
			$table->text('value_create')->nullable();
			$table->text('value_update')->nullable();
			$table->enum('action_type', array('CREATE','UPDATE'))->nullable();
			$table->enum('process_source', array('RENIEC','RENIEC_HERMANOS','RENIEC_FAMILIARES','RENIEC_CONYUGES','CORREOS','MOVISTAR','MOVISTAR_FIJO','CLARO','ENTEL','BITEL','ESSALUD','VEHICULOS_DOCUMENTO','EMPRESAS','EMPRESAS_DOCUMENTO','EMPRESAS_REPRESENTANTES','EMPRESA_TELEFONO','OTHER'))->default('OTHER');
			$table->text('comment')->nullable();
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
		Schema::drop('validata_log_detail_source');
	}

}
