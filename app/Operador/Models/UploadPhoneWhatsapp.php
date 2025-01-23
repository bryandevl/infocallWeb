<?php namespace App\Operador\Models;

class UploadPhoneWhatsapp extends \App\BaseModel
{
	protected $table = "upload_phone_whatsapp";

	public function detail() {
		return $this->hasMany("App\Operador\Models\UploadPhoneWhatsappDetail");
	}
}
