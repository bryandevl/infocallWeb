<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleTelefonoInterface;
use App\Master\Models\PersonaTelefono;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleTelefonoRepository implements SerchPeopleTelefonoInterface
{
	public function getByApi($document = "") {
		$enviroment = env("APP_ENV", "");
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.phone_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($where = []) {
		$personaEssalud = PersonaTelefono::where($where)->first();
		return $personaEssalud;
	}
	public function validate($entity = []) {
		$operadora = $this->getOperador($entity["origen_data"]);
		if ($operadora == "") {
			return ["rst" => 2, "msj" => "No se encuentra una operadora"];
		}
	}
	public function saveBD($entity = [], $entityId = null) {
		$validate = $this->validate($entity);
		if ((int)$validate["rst"] == 2) {
			return $validate;
		}
		$obj = null;
		try {
			DB::beginTransaction();
			$obj = new PersonaTelefono;
			$obj->origen_data = $entity["origen_data"];
			$obj->persona_id = $entity["persona_id"];
			$obj->documento = $entity["documento"];
			$obj->telefono = $entity["telefono"];
			$obj->tipo_telefono = $entity["tipo_telefono"];
			$obj->tipo_operadora = $this->getOperador($entity["origen_data"]);
			$obj->modelo_celular = $entity["modelo_celular"];
			$obj->plan = $entity["plan"];

			$nacimientoTmp = str_replace('/', '-', $entity["fecha_data"]);
			$nacimientoTmp = str_replace(array('/'), array('-'), $nacimientoTmp);
			if (!is_null($nacimientoTmp) && $nacimientoTmp!="" && $nacimientoTmp!="0000-00-00") {
				$date = new \DateTime($nacimientoTmp);
				$obj->fec_data = $date->format("Y-m-d");
			}

			if (!is_null($entity["fecha_activacion"]) && $entity["fecha_activacion"] !="" && $entity["fecha_activacion"] !="0000-00-00") {
				$obj->fec_activacion = date("Y-m-d", strtotime($entity["fecha_activacion"]));
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

	public function getOperador($origenData = "") {
		$operadores = \Config::get("serch.operadores");
		foreach ($operadores as $key => $value) {
			if (is_int(strripos($origenData, "TELEFONICA"))) {
				$value = "MOVISTAR";
				return $value;
			}
			if (is_int(strripos($origenData, $value))) {
				return $value;
			}
		}
		return "OTRO";
	}
	public function getTipoTelefono($origenData = "") {
		
	}
}