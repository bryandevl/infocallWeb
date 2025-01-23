<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleVehicleInterface;
use App\Validata\Models\ValidataPeopleVehicle;
use DB;

class ValidataPeopleVehicleRepository implements ValidataPeopleVehicleInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleVehicle::where([
			"license_plate"	=>	$entity["placa"],
			"validata_people_id" => $entityId
		])->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleVehicle;
				$obj->validata_people_id = $entityId;
				$obj->license_plate = $entity["placa"];
				$obj->save();
			}
			$obj->brand = strtoupper($entity["marca"]);
			$obj->model = strtoupper($entity["modelo"]);
			$obj->class = strtoupper($entity["clase"]);
			$obj->manufacturing = $entity["fabricacion"];
			$obj->purchase = $entity["compra"];
			$obj->transfer_number = $entity["nrotransferencia"];
			$obj->type = strtoupper($entity["tipo"]);
			$obj->document_two = $entity["documento2"];
			$obj->fullname_two = strtoupper($entity["nombrecompleto2"]);
			$obj->property_type = strtoupper($entity["tipodepropiedad"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}