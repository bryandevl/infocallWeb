<?php

use Illuminate\Database\Migrations\Migration;

class AddUbigeoDescriptionColumnToValidataPeopleAddressTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_people_address', function ($table) {
            $table->string('ubigeo_description')->after('ubigeo')->nullable();
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
            $table->dropColumn('ubigeo_description');
        });
    }
}
