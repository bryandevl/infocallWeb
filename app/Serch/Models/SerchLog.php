<?php namespace App\Serch\Models;

class SerchLog extends \App\BaseModel
{
	protected $table = "serch_log";

	public function logApi()
	{
		return $this->hasMany("App\Serch\Models\SerchLogApi", "serch_log_id", "id");
	}
	public function detail()
	{
		return $this->hasMany("App\Serch\Models\SerchLogDetail", "serch_log_id", "id");
	}
}
