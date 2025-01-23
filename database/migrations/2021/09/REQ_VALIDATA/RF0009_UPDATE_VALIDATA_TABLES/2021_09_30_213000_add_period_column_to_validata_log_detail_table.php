<?php

use Illuminate\Database\Migrations\Migration;

class AddPeriodColumnToValidataLogDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_log_detail', function ($table) {
            $table->string('period', 10)->after('campaign_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_log_detail', function ($table) {
            $table->dropColumn('period');
        });
    }
}
