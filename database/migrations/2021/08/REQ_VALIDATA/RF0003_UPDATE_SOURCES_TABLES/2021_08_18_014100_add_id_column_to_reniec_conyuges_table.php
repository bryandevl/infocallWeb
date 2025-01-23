<?php

use Illuminate\Database\Migrations\Migration;

class AddIdColumnToReniecConyugesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_conyuges', function ($table) {
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
        Schema::table('reniec_conyuges', function ($table) {
            $table->dropColumn('id');
        });
    }
}
