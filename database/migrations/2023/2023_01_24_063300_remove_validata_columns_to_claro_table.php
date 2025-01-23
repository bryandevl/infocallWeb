<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RemoveValidataColumnsToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA CLARO][START] : ".date("Y-m-d H:i:s"));

        Schema::table('claro', function ($table) {
            if (Schema::hasColumn("claro", "validata_created_at")) {
                $table->dropColumn("validata_created_at");
            }
            if (Schema::hasColumn("claro", "validata_updated_at")) {
                $table->dropColumn("validata_updated_at");
            }
        });

        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMNS TABLA CLARO][END] : ".date("Y-m-d H:i:s"));
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
