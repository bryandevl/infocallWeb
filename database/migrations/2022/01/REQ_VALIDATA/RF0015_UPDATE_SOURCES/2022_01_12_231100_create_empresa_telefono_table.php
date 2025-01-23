<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateEmpresaTelefonoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_telefono', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ruc', 20)->index('IDX_EMPRESA_TELEFONO__TIPO_RUC')->nullable();
            $table->string('razonsocial', 12)->index('IDX_EMPRESA_TELEFONO__RAZONSOCIAL')->nullable();
            $table->string('numero', 20)->index('IDX_EMPRESA_TELEFONO__NUMERO')->nullable();
            $table->string('tipo', 20)->index('IDX_EMPRESA_TELEFONO__TIPO')->nullable();
            $table->string('fuente', 20)->index('IDX_EMPRESA_TELEFONO__FUENTE')->nullable();

            $table->dateTime('validata_created_at')->nullable();
            $table->dateTime('validata_updated_at')->nullable();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa_telefono');
    }
}
