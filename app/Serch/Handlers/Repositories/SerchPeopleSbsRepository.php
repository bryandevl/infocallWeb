<?php namespace App\Serch\Handlers\Repositories;

use App\Serch\Handlers\SerchPeopleSbsInterface;
use App\Master\Models\PersonaSbs;
use App\Serch\Helpers\SerchApiHelper;
use DB;

class SerchPeopleSbsRepository implements SerchPeopleSbsInterface
{
	public function getByApi($document = "") {
		$enviroment = env("APP_ENV", "");
		$endPointApi = \Config::get("serch.api.endpoint.{$enviroment}.sbs_info");
		$response = SerchApiHelper::getApiUrl($endPointApi, $document);
		return $response;
	}
	public function getByBD($document = "") {
		$persona = PersonaSbs::where("documento", $document)->first();
		return $persona;
	}
	public function saveBD($entity = [], $entityId = null) {
		$obj = null;
		try {
			DB::beginTransaction();
			if (is_null($entityId)) {
				$obj = new PersonaSbs;
				$obj->documento = $entity["documento"];
				$obj->persona_id = $entity["persona_id"];

			} else {
				$obj = PersonaSbs::find($entityId);
			}
			$obj->cod_sbs = $entity["cod_sbs"];

			$nacimientoTmp = str_replace('/', '-', $entity["fecha_reporte_sbs"]);
			$nacimientoTmp = str_replace(array('/'), array('-'), $nacimientoTmp);
			$date = new \DateTime($nacimientoTmp);
			$obj->fecha_reporte_sbs = $date->format("Y-m-d");

			$obj->ruc = $entity["ruc"];
			$obj->cant_empresas = (int)$entity["cant_empresas"];
			$obj->calificacion_normal = (double)$entity["calificacion_normal"];
			$obj->calificacion_cpp = (double)$entity["calificacion_cpp"];
			$obj->calificacion_deficiente = (double)$entity["calificacion_deficiente"];
			$obj->calificacion_dudoso = (double)$entity["calificacion_dudoso"];
			$obj->calificacion_perdida = (double)$entity["calificacion_perdida"];
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