<?php

use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtColumnToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar_fijo', function ($table) {
            $table->dateTime('updated_at')->after('created_at')->nullable();
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
            $table->dropColumn('updated_at');
        });
    }
}
