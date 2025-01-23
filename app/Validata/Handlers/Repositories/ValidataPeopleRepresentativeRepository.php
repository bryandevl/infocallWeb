<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleRepresentativeInterface;
use App\Validata\Models\ValidataPeopleRepresentative;
use DB;

class ValidataPeopleRepresentativeRepository implements ValidataPeopleRepresentativeInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleRepresentative::where("validata_people_id", $entityId)
			->where("document", $entity["documento"])
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleRepresentative;
				$obj->validata_people_id = $entityId;
				$obj->document = $entity["documento"];
				$obj->save();
			}
			$obj->document_type = strtoupper($entity["tipo_documento"]);
			$obj->fullname = strtoupper($entity["nombres"]);
			$obj->turn = strtoupper($entity["cargo"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}