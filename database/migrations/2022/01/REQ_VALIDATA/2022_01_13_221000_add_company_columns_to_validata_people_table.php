<?php

use Illuminate\Database\Migrations\Migration;

class AddCompanyColumnsToValidataPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_people', function ($table) {
            $table->string("ubigee", 20)->index("IDX_VALIDATA_PEOPLE__UBIGEE")->after("mother_name")->nullable();
            $table->string("address", 500)->index("IDX_VALIDATA_PEOPLE__ADDRESS")->after("ubigee")->nullable();
            $table->string("district", 200)->index("IDX_VALIDATA_PEOPLE__DISTRICT")->after("address")->nullable();
            $table->string("province", 200)->index("IDX_VALIDATA_PEOPLE__PROVINCE")->after("district")->nullable();
            $table->string("department", 200)->index("IDX_VALIDATA_PEOPLE__DEPARTMENT")->after("province")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_people', function ($table) {
            $table->dropColumn("ubigee");
            $table->dropColumn("address");
            $table->dropColumn("district");
            $table->dropColumn("province");
            $table->dropColumn("department");
        });
    }
}
