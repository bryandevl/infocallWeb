<?php

use Illuminate\Database\Migrations\Migration;

class AddScoringColumnsToMovistarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar', function ($table) {
            $table->string("origen_data", 100)
                ->index("IDX_MOVISTAR__ORIGEN_DATA")
                ->after("numero")
                ->nullable();
            $table->date("fecha_data")
                ->index("IDX_MOVISTAR__FECHA_DATA")
                ->after("origen_data")
                ->nullable();
            $table->string("plan", 200)
                ->index("IDX_MOVISTAR__PLAN")
                ->after("fecha_data")
                ->nullable();
            $table->date("fecha_activacion")
                ->index("IDX_MOVISTAR__FECHA_ACTIVACION")
                ->after("plan")
                ->nullable();
            $table->string("modelo", 200)
                ->index("IDX_MOVISTAR__MODELO")
                ->after("fecha_activacion")
                ->nullable();
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
            $table->dropColumn("numero");
            $table->dropColumn("origen_data");
            $table->dropColumn("fecha_data");
            $table->dropColumn("plan");
            $table->dropColumn("modelo");
        });
    }
}
