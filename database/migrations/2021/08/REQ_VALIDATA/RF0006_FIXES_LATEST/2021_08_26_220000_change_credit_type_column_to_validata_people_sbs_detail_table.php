<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeCreditTypeColumnToValidataPeopleSbsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE validata_people_sbs_detail MODIFY credit_type ENUM('TARJETA','PRESTAMO','HIPOTECARIO','VEHICULAR','COMERCIAL','CONVENIO','OTROS')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE validata_people_sbs_detail MODIFY credit_type ENUM('TARJETA','PRESTAMO','HIPOTECARIO','VEHICULAR','COMERCIAL','OTROS')");
    }
}
