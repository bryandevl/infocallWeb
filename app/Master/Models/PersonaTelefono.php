<?php namespace App\Master\Models;

class PersonaTelefono extends \App\BaseModel
{
	protected $table = "persona_telefono";

	public function persona()
	{
		return $this->hasOne("App\Serch\Models\Persona", "id", "persona_id");
	}
}
