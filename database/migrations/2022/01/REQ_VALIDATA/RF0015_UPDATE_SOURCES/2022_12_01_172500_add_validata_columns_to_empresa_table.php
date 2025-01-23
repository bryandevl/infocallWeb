<?php

use Illuminate\Database\Migrations\Migration;

class AddValidataColumnsToEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('empresa', function ($table) {
            $table->dateTime("validata_created_at")->index("IDX_EMPRESA__VALIDATA_CREATED_AT")->after("fec_cron")->nullable();
            $table->dateTime("validata_updated_at")->index("IDX_EMPRESA__VALIDATA_UPDATED_AT")->after("validata_created_at")->nullable();
            $table->string("estado", 100)->index("IDX_EMPRESA__ESTADO")->after("fec_cron")->nullable();
            $table->string("giro", 500)->index("IDX_EMPRESA__GIRO")->after("estado")->nullable();
            $table->string("ubigeo", 20)->index("IDX_EMPRESA__UBIGEO")->after("giro")->nullable();
            $table->string("direccion", 500)->index("IDX_EMPRESA__DIRECCION")->after("ubigeo")->nullable();
            $table->string("distrito", 100)->index("IDX_EMPRESA__DISTRITO")->after("ubigeo")->nullable();
            $table->string("departamento", 100)->index("IDX_EMPRESA__DEPARTAMENTO")->after("distrito")->nullable();
            $table->string("provincia", 100)->index("IDX_EMPRESA__PROVINCIA")->after("departamento")->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('empresa', function ($table) {
            $table->dropColumn("validata_created_at");
            $table->dropColumn("validata_updated_at");
            $table->dropColumn("estado");
            $table->dropColumn("giro");
            $table->dropColumn("ubigeo");
            $table->dropColumn("direccion");
            $table->dropColumn("distrito");
            $table->dropColumn("departamento");
            $table->dropColumn("provincia");
        });
    }
}
