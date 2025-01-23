<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFilePathColumnToUploadPhoneWhatsappTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('upload_phone_whatsapp', function (Blueprint $table) {
            $table->string("file_path")->after("email_notification")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('upload_phone_whatsapp', function ($table) {
            $table->dropColumn("file_path");
        });
    }
}
