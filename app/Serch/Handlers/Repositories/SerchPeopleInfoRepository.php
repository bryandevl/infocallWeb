<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Master\Models\Persona;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleInfoRepository implements SerchPeopleInfoInterface
{
	public function getByApi($document = "") {
		$enviroment = \Config::get("app.env");
		if ($enviroment  == "testing") {
			$enviroment =  "local";
		}
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.people_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($document = "") {
		$persona = Persona::where("documento", $document)->first();
		return $persona;
	}
	public function saveBD($entity = [], $entityId = null) {
		$obj = null;
		try {
			DB::beginTransaction();
			if (is_null($entityId)) {
				$obj = new Persona;
				$obj->documento = $entity["documento"];
			} else {
				$obj = Persona::find($entityId);
			}
			$obj->ape_paterno = $entity["paterno"];
			$obj->ape_materno = $entity["materno"];
			$obj->nombres = $entity["nombres"];
			$nacimientoTmp = str_replace('/', '-', $entity["nacimiento"]);
			$nacimientoTmp = str_replace(array('/'), array('-'), $nacimientoTmp);
			$date = new \DateTime($nacimientoTmp);
			$obj->fec_nacimiento = $date->format("Y-m-d");

			$obj->ubigeo_nacimiento = $entity["lugar_nacimiento"];
			$obj->padre_nombres = $entity["padre"];
			$obj->madre_nombres = $entity["madre"];
			if (is_numeric($entity["sexo"])) {
				$obj->sexo = $entity["sexo"];
			}
			$obj->estado_civil = $entity["estado_civil"];
			$obj->direccion = $entity["direccion"];
			$obj->ubigeo_direccion = $entity["ubigeo"];
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