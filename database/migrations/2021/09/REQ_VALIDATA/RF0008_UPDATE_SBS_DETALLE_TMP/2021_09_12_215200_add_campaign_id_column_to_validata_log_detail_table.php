<?php

use Illuminate\Database\Migrations\Migration;

class AddCampaignIdColumnToValidataLogDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_log_detail', function ($table) {
            $table->string('campaign_id', 10)->after('document')->nullable();
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
            $table->dropColumn('campaign_id');
        });
    }
}
