<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\ReniecHermanoInterface;
use App\Models\ReniecHermanos;
use App\Helpers\ValidataHelper;
use DB;

class ReniecHermanoRepository implements ReniecHermanoInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = ReniecHermanos::where("doc_parent", $entity["documento"])
				->where("documento", $entity["documento_familiar"])
				->first();

			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"RENIEC_HERMANOS",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new ReniecHermanos;
				$obj->setPrimaryKey('id');
				$obj->doc_parent = $entity["documento"];
				$obj->documento = $entity["documento_familiar"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey('id');
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
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
			$obj = ReniecHermanos::where("doc_parent", $document)
				->where("documento", $entity["documento_familiar"])
				->first();

			if (is_null($obj)) {
				$obj = new ReniecHermanos;
				$obj->setPrimaryKey('id');
				$obj->doc_parent = $document;
				$obj->documento = $entity["documento_familiar"];
				$obj->created_at = date("Y-m-d H:i:s");
			} else {
				$obj->setPrimaryKey('id');
				$obj->updated_at = date("Y-m-d H:i:s");
			}
			$obj->nombre = ValidataHelper::getFullNameRelative($entity);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return [
				"rst" => 2,
				"msj" => "Error BD: ".$e->getMessage()."\n\n Error Trace String : ".$e->getTraceAsString()
			];
		}
	}
}