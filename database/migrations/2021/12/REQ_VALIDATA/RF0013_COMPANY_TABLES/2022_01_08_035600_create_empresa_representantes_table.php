<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaRepresentantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_representantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_documento')->index('IDX_EMPRESA_REPRESENTANTES__TIPO_DOCUMENTO')->nullable();
            $table->string('documento', 12)->index('IDX_EMPRESA_REPRESENTANTES__DOCUMENTO')->nullable();
            $table->string('ruc', 20)->index('IDX_EMPRESA_REPRESENTANTES__RUC')->nullable();
            $table->string('nombres', 500)->index('IDX_EMPRESA_REPRESENTANTES__NOMBRES')->nullable();
            $table->string('cargo', 50)->index('IDX_EMPRESA_REPRESENTANTES__CARGO')->nullable();

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
        Schema::dropIfExists('empresa_representantes');
    }
}
