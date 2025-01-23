<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToEssaludTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('essalud', function ($table) {
            $table->dateTime('validata_created_at')->after('sueldo')->nullable();
            $table->dateTime('validata_updated_at')->after('sueldo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('essalud', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
