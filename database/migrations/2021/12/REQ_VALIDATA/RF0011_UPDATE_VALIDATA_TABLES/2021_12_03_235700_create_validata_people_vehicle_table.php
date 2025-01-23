<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataPeopleVehicleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_people_vehicle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_people_id')->index('IDX_VALIDATA_PEOPLE_VEHICLE__VALIDATA_PEOPLE_ID')->nullable();
            $table->string('license_plate')->index('IDX_VALIDATA_PEOPLE_VEHICLE__LICENSE_PLATE')->nullable();
            $table->string('brand')->index('IDX_VALIDATA_PEOPLE_VEHICLE__BRAND')->nullable();
            $table->string('model')->index('IDX_VALIDATA_PEOPLE_VEHICLE__MODEL')->nullable();
            $table->string('class')->index('IDX_VALIDATA_PEOPLE_VEHICLE__CLASS')->nullable();
            $table->string('manufacturing', 4)->index('IDX_VALIDATA_PEOPLE_VEHICLE__MANUFACTURING')->nullable();
            $table->string('purchase')->index('IDX_VALIDATA_PEOPLE_VEHICLE__PURCHASE')->nullable();
            $table->string('transfer_number')->index('IDX_VALIDATA_PEOPLE_VEHICLE__TRANSFER_NUMBER')->nullable();
            $table->string('type')->index('IDX_VALIDATA_PEOPLE_VEHICLE__TYPE')->nullable();
            $table->string('document_two', 12)->index('IDX_VALIDATA_PEOPLE_VEHICLE__DOCUMENT_TWO')->nullable();
            $table->string('fullname_two', 500)->index('IDX_VALIDATA_PEOPLE_VEHICLE__FULLNAME_TWO')->nullable();
            $table->string('property_type')->index('IDX_VALIDATA_PEOPLE_VEHICLE__PROPERTY_TYPE')->nullable();

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
        Schema::dropIfExists('validata_people_vehicle');
    }
}
