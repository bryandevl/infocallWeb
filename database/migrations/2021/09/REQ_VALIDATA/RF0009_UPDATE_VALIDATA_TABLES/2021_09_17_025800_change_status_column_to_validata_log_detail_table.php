<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeStatusColumnToValidataLogDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE validata_log_detail MODIFY status ENUM('FAILED', 'NOTDATA', 'ONQUEUE', 'PROCESS', 'REGISTER', 'REPEAT') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE validata_log_detail MODIFY status ENUM('FAILED', 'ONQUEUE', 'PROCESS', 'REGISTER') NULL");
    }
}
