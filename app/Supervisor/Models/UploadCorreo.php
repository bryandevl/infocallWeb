<?php namespace App\Supervisor\Models;

class UploadCorreo extends \App\BaseModel
{
	protected $table = "upload_correo";

	public function detail() {
		return $this->hasMany("App\Supervisor\Models\UploadCorreoDetail");
	}
}
