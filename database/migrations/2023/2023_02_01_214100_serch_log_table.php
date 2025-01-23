<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SerchLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('serch_log');
        Schema::dropIfExists('serch_log_detail');
        Schema::dropIfExists('serch_log_api_detail');
        Schema::dropIfExists('serch_log_api');

        Schema::create('serch_log', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('code', 50);
            $table->integer('requests_total')->default(0);
            $table->integer('duplicate_total_on_period')->default(0);
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->string('user_created_at', 80)->nullable();
            $table->string('user_updated_at', 80)->nullable();
            $table->string('user_deleted_at', 80)->nullable();
            $table->integer('userid_created_at')->nullable();
            $table->integer('userid_updated_at')->nullable();
            $table->integer('userid_deleted_at')->nullable();
        });

        Schema::create('serch_log_detail', function(Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('serch_log_id')->index('SERCH_LOG_DETAIL____VALIDATA_LOG_ID_IDX');
            $table->string('document', 20)->nullable()->index('SERCH_LOG_DETAIL____document_IDX');
            $table->string('campaign_id', 10)->nullable();
            $table->string('period', 10)->nullable()->index('SERCH_LOG_DETAIL____PERIOD_IDX');
            $table->enum('status', array('FAILED','NOTDATA','ONQUEUE','PROCESS','REGISTER','REPEAT'))->nullable();
            $table->string('job_id')->nullable();
            $table->dateTime('time_start')->nullable();
            $table->dateTime('time_end')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('serch_log');
        Schema::dropIfExists('serch_log_detail');
    }
}
