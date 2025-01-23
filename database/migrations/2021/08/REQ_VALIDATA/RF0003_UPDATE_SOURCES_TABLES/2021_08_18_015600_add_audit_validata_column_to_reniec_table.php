<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToReniecTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_2018', function ($table) {
            $table->dateTime('validata_created_at')->after('nombre_pat')->nullable();
            $table->dateTime('validata_updated_at')->after('nombre_pat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reniec_2018', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
