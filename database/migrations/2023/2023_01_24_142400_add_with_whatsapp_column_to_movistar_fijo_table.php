<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddWithWhatsappColumnToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar_fijo', function ($table) {
            $table->boolean("with_whatsapp")
                ->after("modelo")
                ->default(false);
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
            $table->dropColumn("with_whatsapp");
        });
    }
}
