<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleEmailsInterface;
use App\Validata\Models\ValidataPeopleEmail;
use DB;

class ValidataPeopleEmailsRepository implements ValidataPeopleEmailsInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleEmail::where("validata_people_id", $entityId)
			->where("email", $entity["correo"])
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleEmail;
				$obj->validata_people_id = $entityId;
				$obj->email = $entity["correo"];
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