<?php

use Illuminate\Database\Migrations\Migration;

class ChangeDocumentoColumnToBitelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bitel', function ($table) {
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
        Schema::table('bitel', function ($table) {
            $table->integer()->change();
        });
    }
}
