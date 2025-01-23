<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleEssaludInterface;
use App\Validata\Models\ValidataPeopleEssalud;
use DB;

class ValidataPeopleEssaludRepository implements ValidataPeopleEssaludInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleEssalud::where("validata_people_id", $entityId)
			->where("period", $entity["fecha"])
			->where("ruc", $entity["ruc"])
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleEssalud;
				$obj->validata_people_id = $entityId;
				$obj->period = $entity["fecha"];
				$obj->ruc = $entity["ruc"];
				$obj->company_name = strtoupper($entity["nombre_empresa"]);
				$obj->salary = (double)($entity["sueldo"]*55.55);
				$obj->situation = strtoupper($entity["situacion"]);
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