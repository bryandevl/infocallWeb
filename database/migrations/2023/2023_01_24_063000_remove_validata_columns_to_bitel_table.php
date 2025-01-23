<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RemoveValidataColumnsToBitelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA BITEL][START] : ".date("Y-m-d H:i:s"));

        Schema::table('bitel', function ($table) {
            $table->dropColumn("validata_created_at");
            $table->dropColumn("validata_updated_at");
        });

        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA BITEL][END] : ".date("Y-m-d H:i:s"));
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
