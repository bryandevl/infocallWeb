<?php

use Illuminate\Database\Migrations\Migration;

class AddTimestampsColumnToReniecConyugesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_conyuges', function ($table) {
            $table->timestamps();
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
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
