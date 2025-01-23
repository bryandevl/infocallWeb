<?php namespace App\Master\Models;

class Persona extends \App\BaseModel
{
	protected $table = "persona";

	public function sbs()
	{
		return $this->hasOne("App\Master\Models\PersonaSbs", "persona_id", "id");
	}
	public function ubigeo()
	{
		return $this->hasOne("App\Models\Ubigeo", "ubigeo", "ubigeo_nacimiento");
	}
	public function essalud()
	{
		return $this->hasMany("App\Master\Models\PersonaEssalud", "persona_id", "id");
	}
	public function telefono()
	{
		return $this->hasMany("App\Master\Models\PersonaTelefono", "persona_id", "id");
	}
	public function correo()
	{
		return $this->hasMany("App\Master\Models\PersonaCorreo", "persona_id", "id");
	}
	public function familiar()
	{
		return $this->hasMany("App\Master\Models\PersonaFamiliar", "persona_id", "id");
	}
}
