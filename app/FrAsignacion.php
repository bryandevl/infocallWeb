<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class FrAsignacion extends Model
{
	protected $connection = "sqlsrv";
	protected $table = 'FR_ASIGNACION';
	public $timestamps = false;

	protected $fillable = [
		"cNUM_DOCUMENTO",
		"campaign_id",
		"cACTIVO",
		"dFEC_MODIFICA",
		"nEstado",
		"cSendProcess"
	];
}
