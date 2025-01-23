<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_people', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('document', 20)->unique();
            $table->string('last_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('names')->nullable();
            $table->date('birth')->nullable();
            $table->string('birth_place')->nullable();
            $table->enum('sex', ['MASCULINO', 'FEMENINO'])->nullable();
            $table->enum('marital_status', ['SOLTERO', 'CASADO', 'CONVIVIENTE', 'VIUDO', 'NOIDENTIFICADO'])->default('NOIDENTIFICADO');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();

            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('user_created_at', 80)->nullable();
            $table->string('user_updated_at', 80)->nullable();
            $table->string('user_deleted_at', 80)->nullable();
            $table->integer('userid_created_at')->nullable();
            $table->integer('userid_updated_at')->nullable();
            $table->integer('userid_deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validata_people');
    }
}
