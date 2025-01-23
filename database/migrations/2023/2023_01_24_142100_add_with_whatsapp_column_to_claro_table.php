<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddWithWhatsappColumnToClaroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('claro', function ($table) {
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
        Schema::table('claro', function ($table) {
            $table->dropColumn("with_whatsapp");
        });
    }
}
