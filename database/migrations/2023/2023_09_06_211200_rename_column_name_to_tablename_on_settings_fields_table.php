<?php

use Illuminate\Database\Migrations\Migration;

class RenameColumnNameToTablenameOnSettingsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings_fields', function ($table) {
            $table->renameColumn('columnName', 'tablename');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings_fields', function ($table) {
            $table->renameColumn('tablename', 'columnName');
        });
    }
}
