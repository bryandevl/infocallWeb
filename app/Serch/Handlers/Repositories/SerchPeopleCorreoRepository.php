<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleCorreoInterface;
use App\Master\Models\PersonaCorreo;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleCorreoRepository implements SerchPeopleCorreoInterface
{
	public function getByApi($document = "") {
		$enviroment = env("APP_ENV", "");
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.email_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($where = []) {
		$personaCorreo = PersonaCorreo::where($where)->first();
		return $personaCorreo;
	}
	public function saveBD($entity = [], $entityId = null) {
		$obj = null;
		try {
			DB::beginTransaction();
			
			$obj = new PersonaCorreo;
			$obj->persona_id = $entity["persona_id"];
			$obj->documento = $entity["documento"];
			$obj->email = $entity["email"];

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