<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_company', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('id_number', 20)->index('IDX_VALIDATA_COMPANY__ID_NUMBER')->nullable();
            $table->string('business_name', 500)->index('IDX_VALIDATA_COMPANY__BUSINESS_NAME')->nullable();
            $table->string('tradename')->index('IDX_VALIDATA_COMPANY__TRADENAME')->nullable();
            $table->string('type')->index('IDX_VALIDATA_COMPANY__TYPE')->nullable();
            $table->date('registration_date')->index('IDX_VALIDATA_COMPANY__REGISTRATION_DATE')->nullable();
            $table->string('status')->index('IDX_VALIDATA_COMPANY__STATUS')->nullable();
            $table->date('down_date')->index('IDX_VALIDATA_COMPANY__DOWN_DATE')->nullable();
            $table->string('condtion', 200)->index('IDX_VALIDATA_COMPANY__CONDITION')->nullable();
            $table->string('turn')->index('IDX_VALIDATA_COMPANY__TURN')->nullable();
            $table->string('ubigee')->index('IDX_VALIDATA_COMPANY__UBIGEE')->nullable();
            $table->string('address', 500)->index('IDX_VALIDATA_COMPANY__ADDRESS')->nullable();
            $table->string('district')->index('IDX_VALIDATA_COMPANY__DISTRICT')->nullable();
            $table->string('province', 500)->index('IDX_VALIDATA_COMPANY__PROVINCE')->nullable();
            $table->string('department', 500)->index('IDX_VALIDATA_COMPANY__DEPARTMENT')->nullable();

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
        Schema::dropIfExists('validata_company');
    }
}
