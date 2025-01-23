<?php

use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtColumnToMovistarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar', function ($table) {
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
        Schema::table('movistar', function ($table) {
            $table->dropColumn('updated_at');
        });
    }
}
