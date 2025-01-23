<?php

use Illuminate\Database\Migrations\Migration;

class ChangeDocumentoColumnToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claro', function ($table) {
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
        Schema::table('claro', function ($table) {
            $table->integer()->change();
        });
    }
}
