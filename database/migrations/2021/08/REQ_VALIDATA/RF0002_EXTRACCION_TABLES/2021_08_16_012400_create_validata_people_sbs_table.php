<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataPeopleSbsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_people_sbs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_people_id')->nullable();
            $table->date('report_date')->nullable();
            $table->integer('company_quantity')->default(0);
            $table->decimal('normal_rating', 6, 2)->default('0.00');
            $table->decimal('cpp_rating', 6, 2)->default('0.00');
            $table->decimal('deficient_rating', 6, 2)->default('0.00');
            $table->decimal('uncertain_rating', 6, 2)->default('0.00');
            $table->decimal('lost_rating', 6, 2)->default('0.00');

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
        Schema::dropIfExists('validata_people_sbs');
    }
}
