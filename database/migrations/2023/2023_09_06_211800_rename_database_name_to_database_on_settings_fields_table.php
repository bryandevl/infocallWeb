<?php

use Illuminate\Database\Migrations\Migration;

class RenameDatabaseNameToDatabaseOnSettingsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings_fields', function ($table) {
            $table->renameColumn('databaseName', 'database');
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
            $table->renameColumn('database', 'databaseName');
        });
    }
}
