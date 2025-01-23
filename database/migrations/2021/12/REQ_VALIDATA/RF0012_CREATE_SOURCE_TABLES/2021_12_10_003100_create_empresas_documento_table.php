<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasDocumentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas_documento', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('documento', 12)->index('IDX_EMPRESAS_DOCUMENTO__DOCUMENTO')->nullable();
            $table->string('ruc', 20)->index('IDX_EMPRESAS_DOCUMENTO__RUC')->nullable();
            $table->string('razonsocial', 500)->index('IDX_EMPRESAS_DOCUMENTO__RAZONSOCIAL')->nullable();
            $table->string('nombrecomercial', 500)->index('IDX_EMPRESAS_DOCUMENTO__NOMBRECOMERCIAL')->nullable();
            $table->string('tipo')->index('IDX_EMPRESAS_DOCUMENTO__TIPO')->nullable();
            $table->date('fecha_inscripcion')->index('IDX_EMPRESAS_DOCUMENTO__FECHA_INSCRIPCION')->nullable();
            $table->string('estado')->index('IDX_EMPRESAS_DOCUMENTO__ESTADO')->nullable();
            $table->date('fecha_baja')->index('IDX_EMPRESAS_DOCUMENTO__FECHA_BAJA')->nullable();
            $table->string('condicion', 200)->index('IDX_EMPRESAS_DOCUMENTO__CONDICION')->nullable();
            $table->string('giro')->index('IDX_EMPRESAS_DOCUMENTO__GIRO')->nullable();
            $table->string('ubigeo')->index('IDX_EMPRESAS_DOCUMENTO__UBIGEO')->nullable();
            $table->string('direccion', 500)->index('IDX_EMPRESAS_DOCUMENTO__DIRECCION')->nullable();
            $table->string('distrito')->index('IDX_EMPRESAS_DOCUMENTO__DISTRITO')->nullable();
            $table->string('provincia', 500)->index('IDX_EMPRESAS_DOCUMENTO__PROVINCIA')->nullable();
            $table->string('departmento', 500)->index('IDX_EMPRESAS_DOCUMENTO__DEPARTMENTO')->nullable();

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
        Schema::dropIfExists('empresas_documento');
    }
}
