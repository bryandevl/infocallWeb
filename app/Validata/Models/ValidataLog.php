<?php namespace App\Validata\Models;

class ValidataLog extends \App\BaseModel
{
	protected $table = "validata_log";

	public function detail()
	{
		return $this->hasMany("App\Validata\Models\ValidataLogDetail", "validata_log_id", "id");
	}
}
