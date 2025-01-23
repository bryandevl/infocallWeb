<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToEssaludTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('essalud', function ($table) {
            $table->bigIncrements('id')->first();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('essalud', function ($table) {
            $table->dropColumn('id');
        });
    }
}
