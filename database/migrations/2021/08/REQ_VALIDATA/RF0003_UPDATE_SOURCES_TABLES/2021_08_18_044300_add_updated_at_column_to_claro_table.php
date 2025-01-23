<?php

use Illuminate\Database\Migrations\Migration;

class AddUpdatedAtColumnToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claro', function ($table) {
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
        Schema::table('claro', function ($table) {
            $table->dropColumn('updated_at');
        });
    }
}
