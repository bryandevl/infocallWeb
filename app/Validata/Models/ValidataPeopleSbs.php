<?php namespace App\Validata\Models;

class ValidataPeopleSbs extends \App\BaseModel
{
	protected $table = "validata_people_sbs";

	public function detail()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleSbsDetail", "validata_people_sbs_id", "id");
	}

	public function people()
	{
		return $this->hasOne("App\Validata\Models\ValidataPeople", "id", "validata_people_id");
	}
}
