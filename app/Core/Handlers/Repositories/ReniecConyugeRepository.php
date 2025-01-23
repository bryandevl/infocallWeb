<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\ReniecConyugeInterface;
use App\Models\ReniecConyuges;
use App\Helpers\ValidataHelper;
use DB;

class ReniecConyugeRepository implements ReniecConyugeInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = ReniecConyuges::where("doc_parent", $entity["documento"])
				->where("documento", $entity["documento_familiar"])
				->where("parentezco", $entity["tipo_relacion"])
				->first();

			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"RENIEC_CONYUGES",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new ReniecConyuges;
				$obj->setPrimaryKey("id");
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$obj->doc_parent = $entity["documento"];
				$obj->documento = $entity["documento_familiar"];
				$obj->parentezco = $entity["tipo_relacion"];
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			}
			$obj->nombre = ValidataHelper::getFullNameRelative($entity);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}

	public function saveBySerch($document = "", $entity = []) {
		DB::beginTransaction();
		try {
			$obj = ReniecConyuges::where("doc_parent", $document)
				->where("documento", $entity["documento_familiar"])
				->where("parentezco", $entity["tipo_relacion"])
				->first();

			if (is_null($obj)) {
				$obj = new ReniecConyuges;
				$obj->setPrimaryKey("id");
				$obj->created_at = date("Y-m-d H:i:s");
				$obj->doc_parent = $document;
				$obj->documento = $entity["documento_familiar"];
				$obj->parentezco = $entity["tipo_relacion"];
			} else {
				$obj->setPrimaryKey("id");
				$obj->updated_at = date("Y-m-d H:i:s");
			}
			$obj->nombre = ValidataHelper::getFullNameRelative($entity);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}