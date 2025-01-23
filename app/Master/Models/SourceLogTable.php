<?php namespace App\Master\Models;

class SourceLogTable extends \App\BaseModel
{
	protected $table = "source_log_table";

	public function detail()
	{
		return $this->hasMany("App\Master\Models\SourceLogTableDetail", "source_log_table_id", "id");
	}
}
