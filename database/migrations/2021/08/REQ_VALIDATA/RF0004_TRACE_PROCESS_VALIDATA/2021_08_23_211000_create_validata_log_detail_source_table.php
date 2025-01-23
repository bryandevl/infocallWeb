<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidataLogDetailSourceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validata_log_detail_source', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('validata_log_detail_id')->nullable();
            $table->string('document', 20)->nullable();
            $table->text('value_create')->nullable();
            $table->text('value_update')->nullable();
            $table->enum('action_type', ['CREATE', 'UPDATE'])->nullable();
            $table->enum(
                'process_source',
                ['RENIEC', 'RENIEC_HERMANOS', 'RENIEC_FAMILIARES', 'RENIEC_CONYUGES', 'CORREOS', 'MOVISTAR', 'MOVISTAR_FIJO', 'CLARO', 'ENTEL', 'BITEL', 'ESSALUD', 'OTHER']
            )->default('OTHER');
            $table->text('comment')->nullable();

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
        Schema::dropIfExists('validata_log_detail_source');
    }
}
