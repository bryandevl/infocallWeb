<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToReniecFamiliaresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_familiares', function ($table) {
            $table->dateTime('validata_created_at')->after('tipo')->nullable();
            $table->dateTime('validata_updated_at')->after('tipo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reniec_familiares', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
