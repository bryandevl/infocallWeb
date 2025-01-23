<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataCompanyInterface;
use App\Validata\Models\ValidataCompany;
use DB;

class ValidataCompanyRepository implements ValidataCompanyInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataCompany::where("id_number", $entity["ruc"])->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataCompany;
				$obj->id_number = $entity["ruc"];
				$obj->save();
			}
			$obj->business_name = strtoupper($entity["razonsocial"]);
			$obj->tradename = strtoupper($entity["nombrecomercial"]);
			$obj->type = strtoupper($entity["tipo"]);
			if (!empty($entity["fecha_inscripcion"]) && $entity["fecha_inscripcion"]!="0000-00-00") {
				$obj->registration_date = date("Y-m-d", strtotime($entity["fecha_inscripcion"]));
			}
			$obj->status = strtoupper($entity["estado"]);
			if (!empty($entity["fecha_baja"]) && $entity["fecha_baja"]!="0000-00-00") {
				$obj->down_date = date("Y-m-d", strtotime($entity["fecha_baja"]));
			}
			$obj->condition = strtoupper($entity["condicion"]);
			$obj->turn = strtoupper($entity["giro"]);
			$obj->ubigee = strtoupper($entity["ubigeo"]);
			$obj->address = strtoupper($entity["direccion"]);
			$obj->district = strtoupper($entity["distrito"]);
			$obj->province = strtoupper($entity["provincia"]);
			$obj->department = strtoupper($entity["departamento"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}