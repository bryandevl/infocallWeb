<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeProcessSourceColumnToValidataLogDetailSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE validata_log_detail_source MODIFY process_source ENUM('RENIEC','RENIEC_HERMANOS','RENIEC_FAMILIARES','RENIEC_CONYUGES','CORREOS','MOVISTAR','MOVISTAR_FIJO','CLARO','ENTEL','BITEL','ESSALUD', 'VEHICULOS_DOCUMENTO', 'EMPRESAS_DOCUMENTO', 'EMPRESAS_REPRESENTANTES', 'EMPRESA_TELEFONO', 'OTHER') DEFAULT 'OTHER' NOT NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE validata_log_detail_source MODIFY process_source ENUM('RENIEC','RENIEC_HERMANOS','RENIEC_FAMILIARES','RENIEC_CONYUGES','CORREOS','MOVISTAR','MOVISTAR_FIJO','CLARO','ENTEL','BITEL','ESSALUD', 'VEHICULOS_DOCUMENTO', 'EMPRESAS_DOCUMENTO', 'EMPRESAS_REPRESENTANTES', 'OTHER') DEFAULT 'OTHER' NOT NULL");
    }
}
