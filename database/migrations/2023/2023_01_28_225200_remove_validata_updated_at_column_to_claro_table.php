<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RemoveValidataUpdatedAtColumnToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMN VALIDATA_UPDATED_AT TABLA CLARO][START] : ".date("Y-m-d H:i:s"));

        Schema::table('claro', function ($table) {
            $table->dropColumn("validata_updated_at");
        });

        Log::channel("source")
            ->info("[REMOVE VALIDATA COLUMN VALIDATA_UPDATED_AT TABLA CLARO][END] : ".date("Y-m-d H:i:s"));
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
