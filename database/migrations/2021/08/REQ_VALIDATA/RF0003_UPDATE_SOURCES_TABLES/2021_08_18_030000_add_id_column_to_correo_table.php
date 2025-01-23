<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToCorreoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('correo', function ($table) {
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
        Schema::table('correo', function ($table) {
            $table->dropColumn('id');
        });
    }
}
