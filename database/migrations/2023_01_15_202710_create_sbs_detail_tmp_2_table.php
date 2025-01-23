<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSbsDetailTmp2Table extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sbs_detail_tmp_2', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->string('num_documento', 20)->nullable();
			$table->string('campaign_id', 20)->nullable();
			$table->enum('status', array('REGISTER','ONPROCESS','COMPLETED','NOPROCESS'))->default('REGISTER');
			$table->timestamps(10);
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sbs_detail_tmp_2');
	}

}
