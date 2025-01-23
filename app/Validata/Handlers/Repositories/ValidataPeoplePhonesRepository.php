<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeoplePhonesInterface;
use App\Validata\Models\ValidataPeoplePhones;
use DB;

class ValidataPeoplePhonesRepository implements ValidataPeoplePhonesInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeoplePhones::where("validata_people_id", $entityId)
			->where("phone", $entity["telefono"]);
		switch (strtoupper($entity["tipo_telefono"])) {
			case 'F':
				$obj->where('phone_type', 'FIJO');
				break;
			case 'C':
				$obj->where('phone_type', 'CELULAR');
				break;
			default:
				# code...
				break;
		}
		$obj = $obj->where("source_data", strtoupper($entity["origen_data"]))->first();

		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeoplePhones;
				$obj->validata_people_id = $entityId;
				$obj->phone = $entity["telefono"];
				switch (strtoupper($entity["tipo_telefono"])) {
					case 'F':
						$obj->phone_type = 'FIJO';
						break;
					case 'C':
						$obj->phone_type = 'CELULAR';
						break;
					default:
						# code...
						break;
				}
				$obj->source_date = $entity["fecha_data"];
				$obj->plan = $entity["plan"];
				$obj->phone_model = $entity["modelo_celular"];
				$obj->source_data = strtoupper($entity["origen_data"]);
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