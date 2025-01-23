<?php namespace App\Operador\Handlers\Repositories;

use App\Operador\Handlers\UploadPhoneWhatsappListInterface;
use App\Operador\Models\UploadPhoneWhatsapp;
use DB;

class UploadPhoneWhatsappList implements UploadPhoneWhatsappListInterface
{
	public function list($where = [])
	{
		$pathUploads = \Config::get("operador.upload_phone_whatsapp.path_csv");
		$list = 
			UploadPhoneWhatsapp::select([
				"*", 
				DB::raw("IF(is_process=1, 'PROCESADO', 'PENDIENTE') AS flagProcess"),
				DB::raw("IF(sending_email_notification=0, 'NO ENVIADO', 'ENVIADO') AS flagNotification"),
				DB::raw("'$pathUploads' AS pathUpload")
			]);
		if (isset($where["equals"]) && count($where["equals"]) > 0) {
			foreach ($where["equals"] as $key => $value) {
				$list->where($key, $value);
			}
		}
		if (isset($where["raw"]) && count($where["raw"]) > 0) {
			foreach ($where["raw"] as $key => $value) {
				$list->whereRaw($value);
			}
		}
		return $list;
	}
}