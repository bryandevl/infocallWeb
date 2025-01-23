<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ChangeDocParentColumnToReniecHermanosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reniec_hermanos', function (Blueprint $table) {
            $table->bigInteger('doc_parent')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reniec_hermanos', function (Blueprint $table) {
             $table->integer('doc_parent')->nullable()->change();
        });
    }
}
