<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleAddressInterface;
use App\Validata\Models\ValidataPeopleAddress;
use DB;

class ValidataPeopleAddressRepository implements ValidataPeopleAddressInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleAddress::where("validata_people_id", $entityId)
			->where("ubigeo", $entity["ubigeo"])
			->where("source", strtoupper($entity["origen_data"]))
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleAddress;
				$obj->validata_people_id = $entityId;
				$obj->ubigeo = $entity["ubigeo"];
				$obj->ubigeo_description = $entity["descripcion_ubigeo"];
				$obj->address = strtoupper($entity["direccion"]);
				$obj->source = strtoupper($entity["origen_data"]);
				$obj->source_date = $entity["fecha_data"];
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