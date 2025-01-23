<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaniaBaseRegistroTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('campania_base_registro', function(Blueprint $table)
		{
			$table->integer('idcampania_base_registro', true);
			$table->integer('idcampania_base')->index('fk_campania_base_registro_idcampania_base_idx');
			$table->integer('orden');
			$table->integer('code');
			$table->string('firstname', 120)->nullable();
			$table->text('address')->nullable();
			$table->string('city', 45)->nullable();
			$table->string('state', 45)->nullable();
			$table->string('email', 120)->nullable();
			$table->string('cuenta', 45)->nullable();
			$table->integer('edad')->nullable();
			$table->string('empresa_nombre', 45)->nullable();
			$table->string('cliente_tipo', 45)->nullable();
			$table->string('situacion_laboral', 45)->nullable();
			$table->decimal('sueldo', 18)->nullable();
			$table->string('numero_tarjeta', 45)->nullable();
			$table->date('fecha_facturacion')->nullable();
			$table->decimal('facturado_montol', 18)->nullable();
			$table->decimal('deuda_total', 18)->nullable();
			$table->decimal('facturado_saldo_mora', 18)->nullable();
			$table->date('fecha_vencimiento')->nullable();
			$table->decimal('capital_sueldo', 18)->nullable();
			$table->text('direccion_nueva')->nullable();
			$table->string('estatus', 45)->nullable();
			$table->string('telefono_tipo', 45)->nullable();
			$table->string('telefono_nuevo1', 45)->nullable();
			$table->string('telefono_nuevo2', 45)->nullable();
			$table->string('anexo1', 45)->nullable();
			$table->string('anexo2', 45)->nullable();
			$table->text('comentario')->nullable();
			$table->decimal('pago_minimo', 18)->nullable();
			$table->decimal('pago', 18)->nullable();
			$table->integer('dias_mora')->nullable();
			$table->string('clasificacion_riesgo', 45)->nullable();
			$table->string('enitdad_sf', 45)->nullable();
			$table->decimal('rrc_saldo_total', 18)->nullable();
			$table->decimal('refinanciamiento', 18)->nullable();
			$table->decimal('cuota_inicial', 18)->nullable();
			$table->decimal('cuota_entidad', 18)->nullable();
			$table->date('cuota_fecha_vencimiento')->nullable();
			$table->dateTime('contrato_hora')->nullable();
			$table->date('convenio_fecha')->nullable();
			$table->decimal('convenio_monto', 18)->nullable();
			$table->decimal('monto_compromiso', 18)->nullable();
			$table->decimal('sal_mor_120', 18)->nullable();
			$table->decimal('sal_mor_150', 18)->nullable();
			$table->decimal('sal_mor_180', 18)->nullable();
			$table->decimal('sal_mor_210', 18)->nullable();
			$table->decimal('sal_mor_30', 18)->nullable();
			$table->decimal('sal_mor_60', 18)->nullable();
			$table->decimal('sal_mor_90', 18)->nullable();
			$table->decimal('cmc_pagos_mes_1', 18)->nullable();
			$table->decimal('cmc_pagos_mes_2', 18)->nullable();
			$table->decimal('cmc_pagos_mes_3', 18)->nullable();
			$table->decimal('cmc_pagos_mes_4', 18)->nullable();
			$table->decimal('cmc_pagos_mes_5', 18)->nullable();
			$table->decimal('cmc_pagos_mes_6', 18)->nullable();
			$table->string('excepciones', 45)->nullable();
			$table->string('campo', 45)->nullable();
			$table->string('campo_visita', 45)->nullable();
			$table->string('canal_contacto', 45)->nullable();
			$table->string('segmento', 45)->nullable();
			$table->string('tramo_mora', 45)->nullable();
			$table->decimal('campania_monto', 18)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('campania_base_registro');
	}

}
