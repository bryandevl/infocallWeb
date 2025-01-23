<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuditColumnsToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {

            $table
                ->bigInteger('userid_created_at')
                ->after("deleted_at")
                ->nullable();

            $table
                ->bigInteger('userid_updated_at')
                ->after('userid_created_at')
                ->nullable();

            $table
                ->bigInteger('userid_deleted_at')
                ->after('userid_updated_at')
                ->nullable();

            $table
                ->string('user_created_at', 255)
                ->after('userid_deleted_at')
                ->nullable();

            $table
                ->string('user_updated_at', 255)
                ->after('user_created_at')
                ->nullable();

            $table
                ->string('user_deleted_at', 255)
                ->after('user_updated_at')
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
        Schema::table('roles', function ($table) {
            $table->dropColumn("userid_created_at");
            $table->dropColumn("userid_updated_at");
            $table->dropColumn("userid_deleted_at");
            $table->dropColumn("user_created_at");
            $table->dropColumn("user_updated_at");
            $table->dropColumn("user_deleted_at");
        });
    }
}
