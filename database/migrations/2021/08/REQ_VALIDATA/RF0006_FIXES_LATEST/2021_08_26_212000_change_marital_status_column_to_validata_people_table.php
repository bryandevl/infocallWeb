<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeMaritalStatusColumnToValidataPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE validata_people MODIFY marital_status ENUM('SOLTERO','CASADO','CONVIVIENTE','DIVORCIADO','VIUDO','NOIDENTIFICADO')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE validata_people MODIFY marital_status ENUM('SOLTERO','CASADO','CONVIVIENTE','VIUDO','NOIDENTIFICADO')");
    }
}
