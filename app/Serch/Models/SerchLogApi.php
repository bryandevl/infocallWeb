<?php namespace App\Serch\Models;

class SerchLogApi extends \App\BaseModel
{
	protected $table = "serch_log_api";

	public function detail()
	{
		return $this->hasMany("App\Serch\Models\SerchLogApiDetail", "serch_log_api_id", "id");
	}
}
