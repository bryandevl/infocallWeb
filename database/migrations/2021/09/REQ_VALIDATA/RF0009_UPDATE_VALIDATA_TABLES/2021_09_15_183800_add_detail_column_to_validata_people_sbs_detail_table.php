<?php

use Illuminate\Database\Migrations\Migration;

class AddDetailColumnToValidataPeopleSbsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_people_sbs_detail', function ($table) {
            $table->string('credit_type_detail', 255)->after('credit_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_people_sbs_detail', function ($table) {
            $table->dropColumn('credit_type_detail');
        });
    }
}
