<?php

use Illuminate\Database\Migrations\Migration;

class AddScoringColumnsToMovistarFijoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('movistar_fijo', function ($table) {
            $table->string("origen_data", 100)
                ->index("IDX_MOVISTAR_FIJO__ORIGEN_DATA")
                ->after("numero")
                ->nullable();
            $table->date("fecha_data")
                ->index("IDX_MOVISTAR_FIJO__FECHA_DATA")
                ->after("origen_data")
                ->nullable();
            $table->string("plan", 200)
                ->index("IDX_MOVISTAR_FIJO__PLAN")
                ->after("fecha_data")
                ->nullable();
            $table->date("fecha_activacion")
                ->index("IDX_MOVISTAR_FIJO__FECHA_ACTIVACION")
                ->after("plan")
                ->nullable();
            $table->string("modelo", 200)
                ->index("IDX_MOVISTAR_FIJO__MODELO")
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
        Schema::table('movistar_fijo', function ($table) {
            $table->dropColumn("numero");
            $table->dropColumn("origen_data");
            $table->dropColumn("fecha_data");
            $table->dropColumn("plan");
            $table->dropColumn("modelo");
        });
    }
}
