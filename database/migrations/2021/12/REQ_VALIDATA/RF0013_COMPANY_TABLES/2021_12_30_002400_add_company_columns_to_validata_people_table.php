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
            $table->string("business_name", 500)->index("IDX_VALIDATA_PEOPLE__BUSINESS_NAME")->after("names")->nullable();
            $table->string("status_company", 200)->index("IDX_VALIDATA_PEOPLE__STATUS_COMPANY")->after("marital_status")->nullable();
            $table->string("turn_company", 200)->index("IDX_VALIDATA_PEOPLE__TURN_COMPANY")->after("names")->nullable();
        });
        DB::statement("ALTER TABLE validata_people MODIFY sex ENUM('MASCULINO','FEMENINO','EMPRESA') NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_people', function ($table) {
            $table->dropColumn("business_name");
            $table->dropColumn("status_company");
            $table->dropColumn("turn_company");
        });
        DB::statement("ALTER TABLE validata_people MODIFY sex ENUM('MASCULINO','FEMENINO') NULL");
    }
}
