<?php namespace App\Master\Models;

class SourceLog extends \App\BaseModel
{
	protected $table = "source_log";

	public function logApi()
	{
		return $this->hasMany("App\Master\Models\SourceLogTable", "source_log_id", "id");
	}
	public function logTable()
	{
		return $this->hasMany("App\Master\Models\SourceLogTable", "source_log_id", "id");
	}
}
