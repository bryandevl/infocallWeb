<?php namespace App\Validata\Models;

class ValidataPeople extends \App\BaseModel
{
	protected $table = "validata_people";

	public function sbs()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleSbs", "validata_people_id", "id");
	}
	public function sbsTwoYears()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleSbs", "validata_people_id", "id")->orderBy("report_date", "DESC")->limit(24);
	}

	public function sbsLatest()
	{
		return $this->hasOne("App\Validata\Models\ValidataPeopleSbs", "validata_people_id", "id")->latest("report_date");
	}
	
	public function phones()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeoplePhones", "validata_people_id", "id");
	}

	public function emails()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleEmail", "validata_people_id", "id");
	}

	public function essalud()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleEssalud", "validata_people_id", "id");
	}

	public function relatives()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleRelatives", "validata_people_id", "id");
	}

	public function address()
	{
		return $this->hasMany("App\Validata\Models\ValidataPeopleAddress", "validata_people_id", "id");
	}
}
