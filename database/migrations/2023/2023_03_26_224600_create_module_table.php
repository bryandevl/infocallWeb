<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('module', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('class_icon', 20)->nullable();
            $table->string('name', 100);
            $table->string('url', 50)->nullable();
            $table->string('url_controller', 50)->nullable();
            $table->string('path_view', 100)->nullable();
            $table->bigInteger('module_parent_id')->nullable();
            $table->char('visible', 1)->nullable()->default('1');
            $table->integer('order')->nullable()->default(0);
            $table->integer('num_childs')->nullable()->default(0);
            $table->boolean('status')->nullable()->default(true);
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
        Schema::dropIfExists('module');
    }
}
