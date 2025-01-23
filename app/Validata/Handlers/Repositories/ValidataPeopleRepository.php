<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleInterface;
use App\Validata\Models\ValidataPeople;
use App\Validata\Models\ValidataPeopleCompany;
use App\Helpers\CoreHelper;
use DB;

class ValidataPeopleRepository implements ValidataPeopleInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$document = isset($entity["documento"])? $entity["documento"] : (isset($entity["ruc"])? $entity["ruc"] : "");
		$obj = ValidataPeople::where("document", $document)->first();
		$isRuc = CoreHelper::isRuc($document);
				
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeople;
				$obj->document = $document;
				$obj->save();
			}
			if (!$isRuc) {
				$obj->last_name = !is_null($entity["paterno"])? strtoupper($entity["paterno"]) : "";
				$obj->surname = !is_null($entity["materno"])? strtoupper($entity["materno"]) : "";
				$obj->names = !is_null($entity["nombres"])? strtoupper($entity["nombres"]) : "";
				$obj->birth = !is_null($entity["nacimiento"])? $entity["nacimiento"] : null;
				$obj->birth_place = !is_null($entity["lugar_nacimiento"])? strtoupper($entity["lugar_nacimiento"]) : "";
				switch ((int)$entity["sexo"]) {
					case 1:
						$obj->sex = "MASCULINO";
						break;
					case 2:
						$obj->sex = "FEMENINO";
						break;
					default:
						break;
				}
				if ($entity["estado_civil"] !="") {
					$obj->marital_status = strtoupper($entity["estado_civil"]);
				}
				
				$obj->father_name = strtoupper($entity["padre"]);
				$obj->mother_name = strtoupper($entity["madre"]);
				$obj->save();
			} else {
				$obj->business_name = isset($entity["razonsocial"])? strtoupper($entity["razonsocial"]) : "";
				$obj->status_company = isset($entity["estado"])? strtoupper($entity["estado"]) : "";
				$obj->turn_company = isset($entity["giro"])? strtoupper($entity["giro"]) : "";
				$obj->ubigee = isset($entity["ubigeo"])? strtoupper($entity["ubigeo"]) : "";
				$obj->address = isset($entity["direccion"])? strtoupper($entity["direccion"]) : "";
				$obj->district = isset($entity["distrito"])? strtoupper($entity["distrito"]) : "";
				$obj->department = isset($entity["departamento"])? strtoupper($entity["departamento"]) : "";
				$obj->province = isset($entity["provincia"])? strtoupper($entity["provincia"]) : "";
				$obj->save();
			}
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}

	public function saveCompanyBD($entity = [], $entityId = null, $companyId = null) {
		$obj = ValidataPeopleCompany::where([
			"validata_people_id" => $entityId,
			"validata_company_id" => $companyId
		])->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleCompany;
				$obj->validata_people_id = $entityId;
				$obj->validata_company_id = $companyId;
				$obj->save();
			}
			$obj->position = strtoupper($entity["cargo"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}