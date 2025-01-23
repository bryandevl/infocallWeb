<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToMovistarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar', function ($table) {
            $table->dateTime('validata_created_at')->after('numero')->nullable();
            $table->dateTime('validata_updated_at')->after('numero')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('movistar', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
