<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleFamiliarInterface;
use App\Master\Models\PersonaFamiliar;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleFamiliarRepository implements SerchPeopleFamiliarInterface
{
	public function getByApi($document = "") {
		$enviroment = env("APP_ENV", "");
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.familiar_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($where = []) {
		$familiar = PersonaFamiliar::where($where)->first();
		return $familiar;
	}
	public function saveBD($entity = [], $entityId = null) {
		$obj = null;
		try {
			DB::beginTransaction();
			$obj = new PersonaFamiliar;
			$obj->documento = $entity["documento"];
			$obj->documento_familiar = $entity["documento_familiar"];
			$obj->persona_id = $entity["persona_id"];

			$obj->ape_paterno = $entity["paterno_familiar"];
			$obj->ape_materno = $entity["materno_familiar"];
			$obj->nombres = $entity["nombres_familiar"];

			$entity["nacimiento_familiar"] = str_replace(array('/'), array('-'), $entity["nacimiento_familiar"]);
			$date = new \DateTime($entity["nacimiento_familiar"]);
			$obj->fec_nacimiento = $date->format("Y-m-d");

			$obj->tipo = $this->getTipo($entity["tipo_relacion"]);
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

	public function getTipo($tipoRelacion = "")
	{
		if ($tipoRelacion !="") {
			if ($tipoRelacion == "H") {
				return "HIJO";
			}
			if ($tipoRelacion == "C") {
				return "CONCUBINO";
			}
			if ($tipoRelacion == "G") {
				return "CONYUGE";
			}
			$tiposFamiliar = \Config::get("serch.tipos_familiar");
			$indiceExito = array_search($tipoRelacion, $tiposFamiliar);

			if (isset($tiposFamiliar[$indiceExito])) {
				return $tiposFamiliar[$indiceExito];
			}
		}
		return "OTRO";
	}
}