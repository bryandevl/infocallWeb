<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToCorreoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('correo', function ($table) {
            $table->dateTime('validata_created_at')->after('correo')->nullable();
            $table->dateTime('validata_updated_at')->after('correo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('correo', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
