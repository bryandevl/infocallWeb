<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_module', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('role_id')->nullable();
            $table->bigInteger('module_id')->nullable();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->bigInteger('userid_created_at')->nullable();
            $table->bigInteger('userid_updated_at')->nullable();
            $table->bigInteger('userid_deleted_at')->nullable();
            $table->string('user_created_at', 255)->nullable();
            $table->string('user_updated_at', 255)->nullable();
            $table->string('user_deleted_at', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_module');
    }
}
