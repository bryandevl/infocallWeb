<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\CorreoInterface;
use App\Models\Correo;
use DB;

class CorreoRepository implements CorreoInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = Correo::where("documento", $entity["documento"])
				->where("correo", strtoupper($entity["correo"]))
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"CORREOS",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new Correo;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode(["correo" => $entity["correo"]]);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode(["correo" => $entity["correo"]]);
			}
			$obj->correo = strtoupper($entity["correo"]);
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
			$obj = Correo::where("documento", $document)
				->where(["correo" => strtoupper($entity["correo"])])
				->first();

			if (is_null($obj)) {
				$obj = new Correo;
				$obj->setPrimaryKey("id");
				$obj->documento = $document;
				$obj->created_at = date("Y-m-d H:i:s");
			} else {
				$obj->setPrimaryKey("id");
				$obj->updated_at = date("Y-m-d H:i:s");
			}
			$obj->correo = strtoupper($entity["correo"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()."\n\n Error Trace String : ".$e->getTraceAsString()];
		}
	}
}