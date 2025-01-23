<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeTipoColumnToReniecFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE reniec_familiares MODIFY tipo ENUM('PADRE', 'MADRE', 'HIJO') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE reniec_familiares MODIFY tipo ENUM('PADRE', 'MADRE') NULL");
    }
}
