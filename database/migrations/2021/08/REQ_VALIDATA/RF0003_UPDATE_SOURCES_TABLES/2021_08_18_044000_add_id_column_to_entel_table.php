<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToEntelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entel', function ($table) {
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
        Schema::table('entel', function ($table) {
            $table->dropColumn('id');
        });
    }
}
