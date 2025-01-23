<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\EssaludInterface;
use App\Models\Essalud;
use App\Helpers\FormatHelper;
use DB;

class EssaludRepository implements EssaludInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = Essalud::where("documento", $entity["documento"])
				->where("periodo", $entity["fecha"])
				->where("ruc", $entity["ruc"])
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"ESSALUD",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new Essalud;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->periodo = $entity["fecha"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->sueldo = (double)($entity["sueldo"]*55.55);
			$obj->empresa = $entity["nombre_empresa"];
			$obj->condicion = $entity["situacion"];
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}

	public function saveBySerch($document = "", $entity = []) {
		if (empty($entity["ruc"]) || !is_numeric($entity["ruc"])) {
			return ["rst" => 2, "msj" => "RUC está vacío o no es numérico"];
		}
		DB::beginTransaction();
		try {
			$obj = Essalud::where("documento", $document)
				->where("periodo", $entity["fecha"])
				->where("ruc", $entity["ruc"])
				->first();
			
			if (is_null($obj)) {
				$obj = new Essalud;
				$obj->setPrimaryKey("id");
				$obj->documento = $document;
				$obj->periodo = $entity["fecha"];
				$obj->created_at = date("Y-m-d H:i:s");
				
			} else {
				$obj->setPrimaryKey("id");
				$obj->updated_at = date("Y-m-d H:i:s");
			}
			$obj->sueldo = (double)($entity["sueldo"]);
			$obj->empresa = substr(FormatHelper::swapString($entity["nombre_empresa"]), 0, 119) ;
			$obj->condicion = $entity["situacion"];
			$obj->ruc = $entity["ruc"];
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