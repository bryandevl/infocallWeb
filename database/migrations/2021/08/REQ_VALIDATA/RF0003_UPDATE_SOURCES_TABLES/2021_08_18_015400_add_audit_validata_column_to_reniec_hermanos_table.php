<?php

use Illuminate\Database\Migrations\Migration;

class AddAuditValidataColumnToReniecHermanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('reniec_hermanos', 'validata_created_at')) {
            Schema::table('reniec_hermanos', function ($table) {
                $table->dateTime('validata_created_at')->after('nombre')->nullable();
            });
        }
        if (!Schema::hasColumn('reniec_hermanos', 'validata_updated_at')) {
            Schema::table('reniec_hermanos', function ($table) {
                $table->dateTime('validata_updated_at')->after('nombre')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reniec_hermanos', function ($table) {
            $table->dropColumn('validata_created_at');
            $table->dropColumn('validata_updated_at');
        });
    }
}
