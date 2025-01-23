<?php

use Illuminate\Database\Migrations\Migration;

class AddDuplicateTotalOnPeriodColumnToValidataLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_log', function ($table) {
            $table->integer('duplicate_total_on_period')->after('requests_total')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_log', function ($table) {
            $table->dropColumn('duplicate_total_on_period');
        });
    }
}
