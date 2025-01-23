<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar_fijo', function ($table) {
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
        Schema::table('movistar_fijo', function ($table) {
            $table->dropColumn('id');
        });
    }
}
