<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RemoveValidataColumnsToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA MOVISTAR FIJO][START] : ".date("Y-m-d H:i:s"));

        Schema::table('movistar_fijo', function ($table) {
            $table->dropColumn("validata_created_at");
            $table->dropColumn("validata_updated_at");
        });

        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA MOVISTAR FIJO][START] : ".date("Y-m-d H:i:s"));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
