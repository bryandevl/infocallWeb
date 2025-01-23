<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddcSendProcessColumnToFrAsignacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection("sqlsrv")
            ->table('FR_ASIGNACION', function ($table) {
                $table->integer("cSendProcess")->default(0);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::connection("sqlsrv")->hasColumn("FR_ASIGNACION", "cSendProcess")) {
            Schema::connection("sqlsrv")
                ->table('FR_ASIGNACION', function ($table) {
                    //$table->dropForeign(['cSendProcess']);
                    $table->dropColumn("cSendProcess");
                    //DB::statement("ALTER TABLE FR_ASIGNACION DROP CONSTRAINT 'DF__FR_ASIGNA__cSend__24927208', COLUMN 'cSendProcess'");
                }
            );
        }
    }
}
