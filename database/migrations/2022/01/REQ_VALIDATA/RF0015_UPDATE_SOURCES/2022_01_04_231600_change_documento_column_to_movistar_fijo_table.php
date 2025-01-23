<?php

use Illuminate\Database\Migrations\Migration;

class ChangeDocumentoColumnToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar_fijo', function ($table) {
            $table->bigInteger('documento')->change();
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
            $table->integer()->change();
        });
    }
}
