<?php namespace App\Operador\Models;

class UploadProcessTranslate extends \App\BaseModel
{
	protected $table = "upload_process_translate";
	protected $with = ["financeEntity"];

	public function financeEntity()
	{
		return $this->hasOne("\App\Master\Models\FinanceEntity", "id", "finance_entity_id");
	}

	public function detail()
	{
		return $this->hasMany("\App\Operador\Models\UploadProcessTranslateDetail", "upload_process_translate_id", "id");
	}
}
