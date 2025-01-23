<?php

use Illuminate\Database\Migrations\Migration;

class AddSourceDateColumnToValidataPeopleAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_people_address', function ($table) {
            $table->date('source_date')->after('source')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_people_address', function ($table) {
            $table->dropColumn('source_date');
        });
    }
}
