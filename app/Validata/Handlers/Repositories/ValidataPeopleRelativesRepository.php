<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleRelativesInterface;
use App\Validata\Models\ValidataPeopleRelatives;
use DB;

class ValidataPeopleRelativesRepository implements ValidataPeopleRelativesInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleRelatives::where("validata_people_id", $entityId)
			->where("document", $entity["documento_familiar"])
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleRelatives;
				$obj->validata_people_id = $entityId;
				$obj->document = $entity["documento_familiar"];
				$obj->last_name = $entity["paterno_familiar"];
				$obj->surname = $entity["materno_familiar"];
				$obj->names = $entity["nombres_familiar"];
				if (!is_null($entity["nacimiento_familiar"]) && $entity["nacimiento_familiar"]!="0000-00-00" && $entity["nacimiento_familiar"]!="") {
					$obj->birth = $entity["nacimiento_familiar"];
				}
				
				switch (strtoupper($entity["tipo_relacion"])) {
					case 'H':
						$obj->relation_type = "HIJO";
						break;
					case 'C':
						$obj->relation_type = "CONCUBINO";
						break;
					case 'G':
						$obj->relation_type = "CONYUGE";
						break;
					case '':
						$obj->relation_type = "NOIDENTIFICADO";
						break;
					default:
						$obj->relation_type = strtoupper($entity["tipo_relacion"]);
						break;
				}
				if (is_null($entity["tipo_relacion"])) {
					$obj->relation_type = "NOIDENTIFICADO";
				}
				$obj->save();
			}
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}