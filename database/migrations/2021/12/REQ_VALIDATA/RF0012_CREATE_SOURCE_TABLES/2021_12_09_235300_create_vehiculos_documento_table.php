<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos_documento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('documento', 12)->index('IDX_VEHICULOS__DOCUMENTO')->nullable();
            $table->string('placa')->index('IDX_VEHICULOS__PLACA')->nullable();
            $table->string('marca')->index('IDX_VEHICULOS__MARCA')->nullable();
            $table->string('modelo')->index('IDX_VEHICULOS__MODELO')->nullable();
            $table->string('clase')->index('IDX_VEHICULOS__CLASE')->nullable();
            $table->string('fabricacion', 4)->index('IDX_VEHICULOS__FABRICACION')->nullable();
            $table->string('compra')->index('IDX_VEHICULOS__COMPRA')->nullable();
            $table->string('numero_transferencia')->index('IDX_VEHICULOS__NUMERO_TRANSFERENCIA')->nullable();
            $table->string('tipo')->index('IDX_VEHICULOS__TIPO')->nullable();
            $table->string('segundo_documento', 12)->index('IDX_VEHICULOS__SEGUNDO_DOCUMENTO')->nullable();
            $table->string('segundo_nombrecompleto', 500)->index('IDX_VEHICULOS__SEGUNDO_NOMBRECOMPLETO')->nullable();
            $table->string('tipo_propiedad')->index('IDX_VEHICULOS__TIPO_PROPIEDAD')->nullable();

            $table->dateTime('validata_created_at')->nullable();
            $table->dateTime('validata_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehiculos_documento');
    }
}
