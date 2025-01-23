<?php

use Illuminate\Database\Migrations\Migration;

class ChangeDocumentoColumnToEssaludTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('essalud', function ($table) {
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
        Schema::table('essalud', function ($table) {
            $table->integer()->change();
        });
    }
}
