<?php namespace App\Operador\Handlers\Repositories;

use App\Operador\Handlers\UploadProcessTranslateListInterface;
use App\Operador\Models\UploadProcessTranslate;
use DB;

class UploadProcessTranslateList implements UploadProcessTranslateListInterface
{
	public function list($where = [])
	{
		$pathUploads = env("APP_PATH_UPLOAD_VOICE", "");
		$list = UploadProcessTranslate::select(
			"*", 
			DB::raw("IF(is_process=1, 'PROCESADO', 'PENDIENTE') AS flagProcess"),
			DB::raw("IF(sending_email_notification=0, 'NO ENVIADO', 'ENVIADO') AS flagNotification"),
			DB::raw("'$pathUploads' AS pathUpload")
		);
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