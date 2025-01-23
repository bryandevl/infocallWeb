<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleEssaludInterface;
use App\Master\Models\PersonaEssalud;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleEssaludRepository implements SerchPeopleEssaludInterface
{
	public function getByApi($document = "") {
		$enviroment = env("APP_ENV", "");
		if ($enviroment == "testing") {
			$enviroment = "local";
		}
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.essalud_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($where = []) {
		$personaEssalud = PersonaEssalud::where($where)->first();
		return $personaEssalud;
	}
	public function saveBD($entity = [], $entityId = null) {
		$obj = null;
		try {
			DB::beginTransaction();
			if (is_null($entityId)) {
				$obj = new PersonaEssalud;
				$obj->documento = $entity["documento"];
				$obj->persona_id = $entity["persona_id"];
				$obj->empresa_id = $entity["empresa_id"];
				$obj->periodo = $entity["fecha"];
				$obj->sueldo = (double)$entity["sueldo"];
				$obj->situacion = $entity["situacion"];
			} else {
				$obj = PersonaEssalud::find($entityId);
			}
			if (isset($entity["fec_cron"])) {
				$obj->fec_cron = $entity["fec_cron"];
			}
			$obj->save();
			DB::commit();
			return ["rst" => 1, "msj" => "Registro Exitoso"];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error de BD"];
		}
	}
}