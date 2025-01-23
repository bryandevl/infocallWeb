<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToMovistarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar', function ($table) {
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
        Schema::table('movistar', function ($table) {
            $table->dropColumn('id');
        });
    }
}
