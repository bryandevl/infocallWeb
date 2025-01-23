<?php

use Illuminate\Database\Migrations\Migration;

class AddScoringColumnsToEntelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entel', function ($table) {
            $table->string("origen_data", 100)
                ->index("IDX_ENTEL__ORIGEN_DATA")
                ->after("numero")
                ->nullable();
            $table->date("fecha_data")
                ->index("IDX_ENTEL__FECHA_DATA")
                ->after("origen_data")
                ->nullable();
            $table->string("plan", 200)
                ->index("IDX_ENTEL__PLAN")
                ->after("fecha_data")
                ->nullable();
            $table->date("fecha_activacion")
                ->index("IDX_ENTEL__FECHA_ACTIVACION")
                ->after("plan")
                ->nullable();
            $table->string("modelo", 200)
                ->index("IDX_ENTEL__MODELO")
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
        Schema::table('entel', function ($table) {
            $table->dropColumn("numero");
            $table->dropColumn("origen_data");
            $table->dropColumn("fecha_data");
            $table->dropColumn("plan");
            $table->dropColumn("modelo");
        });
    }
}
