<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\ReniecFamiliarInterface;
use App\Models\ReniecFamiliares;
use App\Helpers\ValidataHelper;
use DB;

class ReniecFamiliarRepository implements ReniecFamiliarInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = ReniecFamiliares::where("doc_parent", $entity["documento"])
				->where("documento", $entity["documento_familiar"])
				->where("tipo", $entity["tipo_relacion"])
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"RENIEC_FAMILIARES",
				"document"			=>	$entity["documento"]
			];

			if (is_null($obj)) {
				$obj = new ReniecFamiliares;
				$obj->setPrimaryKey('documento');
				$obj->doc_parent = $entity["documento"];
				$obj->documento = $entity["documento_familiar"];
				$obj->tipo = $entity["tipo_relacion"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("documento");
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
		if (!isset($entity["documento_familiar"])) {
			return ["rst" => 2, "msj" => "No existe documento_familiar para {$document}", "entity" => $entity];
		}
		DB::beginTransaction();
		try {
			$obj = ReniecFamiliares::where("doc_parent", $document)
				->where("documento", $entity["documento_familiar"])
				->where("tipo", $entity["tipo_relacion"])
				->first();

			if (is_null($obj)) {
				$obj = new ReniecFamiliares;
				$obj->setPrimaryKey('documento');
				$obj->doc_parent = $document;
				$obj->documento = $entity["documento_familiar"];
				$obj->tipo = $entity["tipo_relacion"];
				$obj->created_at = date("Y-m-d H:i:s");
			} else {
				$obj->setPrimaryKey("documento");
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