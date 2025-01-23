<?php

use Illuminate\Database\Migrations\Migration;

class RenameFieldNameToFieldOnSettingsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings_fields', function ($table) {
            $table->renameColumn('fieldName', 'field');
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
            $table->renameColumn('field', 'fieldName');
        });
    }
}
