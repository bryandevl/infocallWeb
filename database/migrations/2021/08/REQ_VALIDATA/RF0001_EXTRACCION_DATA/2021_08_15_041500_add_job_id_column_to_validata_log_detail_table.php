<?php

use Illuminate\Database\Migrations\Migration;

class AddJobIdColumnToValidataLogDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_log_detail', function ($table) {
            $table->string('job_id')->after('status')->nullable();
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
            $table->dropColumn('job_id');
        });
    }
}
