<?php namespace App\Supervisor\Handlers\Repositories;

use App\Supervisor\Handlers\UploadCorreoListInterface;
use App\Supervisor\Models\UploadCorreo;
use DB;

class UploadCorreoList implements UploadCorreoListInterface
{
	public function list($where = [])
	{
		$pathUploads = config("supervisores.upload_correo.path_csv");
		$list = 
			UploadCorreo::select([
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