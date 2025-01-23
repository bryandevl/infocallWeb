<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSbsDetalleTmpTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sbs_detalle_tmp', function(Blueprint $table)
		{
			$table->bigInteger('id', true)->unsigned();
			$table->dateTime('fec_cruce')->nullable();
			$table->date('fec_reporte')->nullable()->index('SBS_DETALLE_TMP__FEC_REPORTE_IDX');
			$table->string('periodo', 6)->nullable();
			$table->string('documento', 20)->nullable()->index('SBS_DETALLE_TMP__DOCUMENTO_IDX');
			$table->string('ruc', 20)->nullable();
			$table->string('cod_sbs', 50)->nullable();
			$table->string('finance_entity', 500)->nullable()->index('SBS_DETALLE_TMP__FINANCE_ENTITY');
			$table->string('credit_type', 500)->nullable()->index('SBS_DETALLE_TMP__CREDIT_TYPE');
			$table->string('credit_type_detail', 500)->nullable()->index('SBS_DETALLE_TMP__CREDIT_TYPE_DETAIL');
			$table->integer('finance_entity_id')->nullable();
			$table->integer('credit_type_id')->nullable();
			$table->string('condicion', 5)->nullable();
			$table->decimal('monto', 16);
			$table->decimal('linea_tc', 16)->default(0.00);
			$table->decimal('saldo_tc', 16)->default(0.00);
			$table->decimal('saldo_disef', 16)->default(0.00);
			$table->decimal('saldo_con_otros', 16)->default(0.00);
			$table->decimal('saldo_hip_veh', 16)->default(0.00);
			$table->decimal('saldo_cast_ref', 16)->default(0.00);
			$table->decimal('saldo_con', 16)->default(0.00);
			$table->decimal('linea_tc_cnc', 16)->default(0.00);
			$table->decimal('saldo_tc_cnc', 16)->default(0.00);
			$table->decimal('saldo_disef_cnc', 16)->default(0.00);
			$table->decimal('saldo_con_otros_cnc', 16)->default(0.00);
			$table->decimal('saldo_hip_veh_cnc', 16)->default(0.00);
			$table->decimal('saldo_cast_ref_cnc', 16)->default(0.00);
			$table->decimal('linea_tc_fal', 16)->default(0.00);
			$table->decimal('saldo_tc_fal', 16)->default(0.00);
			$table->decimal('saldo_disef_fal', 16)->default(0.00);
			$table->decimal('saldo_con_otros_fal', 16)->default(0.00);
			$table->decimal('saldo_hip_veh_fal', 16)->default(0.00);
			$table->decimal('saldo_cast_ref_fal', 16)->default(0.00);
			$table->decimal('linea_tc_ibk', 16)->default(0.00);
			$table->decimal('saldo_tc_ibk', 16)->default(0.00);
			$table->decimal('saldo_disef_ibk', 16)->default(0.00);
			$table->decimal('saldo_con_otros_ibk', 16)->default(0.00);
			$table->decimal('saldo_hip_veh_ibk', 16)->default(0.00);
			$table->decimal('saldo_cast_ref_ibk', 16)->default(0.00);
			$table->decimal('saldo_banco', 16)->default(0.00);
			$table->decimal('saldo_financiera', 16)->default(0.00);
			$table->decimal('saldo_caja_otros', 16)->default(0.00);
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
		Schema::drop('sbs_detalle_tmp');
	}

}
