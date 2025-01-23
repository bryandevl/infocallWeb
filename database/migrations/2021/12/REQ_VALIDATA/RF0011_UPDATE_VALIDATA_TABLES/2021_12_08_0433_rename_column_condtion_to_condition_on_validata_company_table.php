<?php

use Illuminate\Database\Migrations\Migration;

class RenameColumnCondtionToConditionOnValidataCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_company', function ($table) {
            $table->renameColumn('condtion', 'condition');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_company', function ($table) {
            $table->renameColumn('condition', 'condtion');
        });
    }
}
