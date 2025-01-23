<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\ClaroInterface;
use App\Models\Movistar;
use App\Models\Claro;
use App\Models\Entel;
use App\Models\Bitel;
use App\Models\MovistarFijo;
use DB;

class ClaroRepository implements ClaroInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = Claro::where("documento", $entity["documento"])
				->where("numero", $entity["telefono"])
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"CLARO",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new Claro;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->numero = $entity["telefono"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->nombre = $entity["people"];
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
			      
      // Eliminar registros existentes en todas las tablas antes de insertar
          Claro::where(["documento" => $document, "numero" => $entity["telefono"]])->delete();
            Movistar::where(["documento" => $document, "numero" => $entity["telefono"]])->delete();            
            Entel::where(["documento" => $document, "numero" => $entity["telefono"]])->delete();
            Bitel::where(["documento" => $document, "numero" => $entity["telefono"]])->delete();
            MovistarFijo::where(["documento" => $document, "numero" => $entity["telefono"]])->delete();
      

			$obj = new Claro;
			$obj->setPrimaryKey("id");
			$obj->documento = $document;
			$obj->numero = $entity["telefono"];
			$obj->created_at = date("Y-m-d H:i:s");
			$obj->nombre = $entity["people"];
			$obj->origen_data = !is_null($entity["origen_data"])? $entity["origen_data"] : "";
			if ($entity["fecha_data"] !="0000-00-00") {
				$obj->fecha_data = (!is_null($entity["fecha_data"]) && !empty($entity["fecha_data"]))? date("Y-m-d", strtotime($entity["fecha_data"])) : null;
			} else {
				$obj->fecha_data = null;
			}
			if ($entity["fecha_activacion"]!="0000-00-00") {
				$obj->fecha_activacion = (!is_null($entity["fecha_activacion"]) && !empty($entity["fecha_activacion"]))? date("Y-m-d", strtotime($entity["fecha_activacion"])) : null;
			} else {
				$obj->fecha_activacion = null;
			}
			$obj->plan = !is_null($entity["plan"])? $entity["plan"] : "";
			$obj->modelo = !is_null($entity["modelo_celular"])? $entity["modelo_celular"] : "";
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()."\n\n Error Trace String : ".$e->getTraceAsString()];
		}
	}
}