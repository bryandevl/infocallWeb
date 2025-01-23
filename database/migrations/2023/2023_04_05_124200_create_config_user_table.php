<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConfigUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_user', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 100)->nullable();
            $table->string('key', 50);
            $table->text('value')->nullable();
            $table
                ->tinyInteger('type')
                ->nullable()
                ->default(1)
                ->comment('1: input, 2 : file');
            $table
                ->string('type_input', 50)
                ->default("text");
            $table->boolean('status')->nullable()->default(true);
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->dateTime('updated_at')->nullable();
            $table->softDeletes();
            $table->string('user_created_at', 45)->nullable();
            $table->string('user_updated_at', 45)->nullable();
            $table->string('user_deleted_at', 45)->nullable();
            $table->smallInteger('userid_created_at')->nullable();
            $table->smallInteger('userid_updated_at')->nullable();
            $table->smallInteger('userid_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('config_user');
    }
}
