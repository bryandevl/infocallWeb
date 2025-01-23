<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveUniqueConstraintDocumentColumnToValidataPeopleRelativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('validata_people_relatives', function (Blueprint $table) {
            //$table->dropUnique('document');
            $table->dropIndex('validata_people_relatives_document_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('validata_people_relatives', function (Blueprint $table) {
             $table->string('document', 20)->unique()->change();
        });
    }
}
