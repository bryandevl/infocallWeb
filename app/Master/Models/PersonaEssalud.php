<?php namespace App\Master\Models;

class PersonaEssalud extends \App\BaseModel
{
	protected $table = "persona_essalud";

	public function empresa()
	{
		return $this->hasOne("App\Master\Models\Empresa", "id", "empresa_id");
	}
}
