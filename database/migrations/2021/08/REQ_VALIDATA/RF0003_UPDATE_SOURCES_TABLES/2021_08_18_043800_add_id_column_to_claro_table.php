<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claro', function ($table) {
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
        Schema::table('claro', function ($table) {
            $table->dropColumn('id');
        });
    }
}
