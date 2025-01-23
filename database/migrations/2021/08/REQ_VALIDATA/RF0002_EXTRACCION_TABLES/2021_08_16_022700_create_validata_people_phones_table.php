<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataPeoplePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_people_phones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_people_id')->nullable();
            $table->string('phone')->nullable();
            $table->string('plan')->nullable();
            $table->string('phone_model')->nullable();
            $table->date('source_date')->nullable();
            $table->enum('phone_type', ['FIJO', 'CELULAR', 'NOIDENTIFICADO'])->default('NOIDENTIFICADO');
            $table->enum('source_data', ['MOVISTAR', 'CLARO', 'ENTEL', 'BITEL',  'PAGINAS BLANCAS', 'NOIDENTIFICADO'])->default('NOIDENTIFICADO');

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
        Schema::dropIfExists('validata_people_phones');
    }
}
