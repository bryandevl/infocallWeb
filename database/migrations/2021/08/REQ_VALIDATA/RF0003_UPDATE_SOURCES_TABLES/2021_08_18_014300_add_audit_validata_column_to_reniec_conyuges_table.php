<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToReniecConyugesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_conyuges', function ($table) {
            $table->dateTime('validata_created_at')->nullable();
            $table->dateTime('validata_updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reniec_conyuges', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
