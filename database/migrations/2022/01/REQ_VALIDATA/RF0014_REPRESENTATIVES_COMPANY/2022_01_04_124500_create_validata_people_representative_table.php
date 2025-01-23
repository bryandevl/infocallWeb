<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataPeopleRepresentativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_people_representative', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_people_id')->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__VALIDATA_PEOPLE_ID')->nullable();
            $table->string('document_type', 20)->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__DOCUMENT_TYPE')->nullable();
            $table->string('document', 20)->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__DOCUMENT')->nullable();
            $table->string('fullnmame', 500)->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__FULLNAME')->nullable();
            $table->string('turn')->index('IDX_VALIDATA_PEOPLE_REPRESENTATIVE__TURN')->nullable();

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
        Schema::dropIfExists('validata_people_representative');
    }
}
