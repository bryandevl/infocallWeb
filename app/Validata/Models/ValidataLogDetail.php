<?php namespace App\Validata\Models;

class ValidataLogDetail extends \App\BaseModel
{
	protected $table = "validata_log_detail";

	public function people()
	{
		return $this->hasOne("App\Validata\Models\ValidataPeople", "document", "document");
	}

	public function validataLog()
	{
		return $this->hasOne("App\Validata\Models\ValidataLog", "id", "validata_log_id");
	}

	public function sourceTrace()
	{
		return $this->hasMany("App\Validata\Models\ValidataLogDetailSource", "validata_log_detail_id", "id");
	}
}
