<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\ReniecInterface;
use App\Models\Reniec;
use DB;

class ReniecRepository implements ReniecInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = Reniec::where("documento", $entity["documento"])
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"RENIEC",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new Reniec;
				$obj->documento = $entity["documento"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->apellido_pat = isset($entity["paterno"])? $entity["paterno"] : "";
			$obj->apellido_mat = isset($entity["materno"])? $entity["materno"] : "";
			$obj->nombre = isset($entity["nombres"])? $entity["nombres"] : "";
			if (isset($entity["sexo"]) && $entity["sexo"] !="") {
				$obj->sexo = $entity["sexo"];
			}
			if (isset($entity["nacimiento"])) {
				$obj->fec_nac = date("d/m/Y", strtotime($entity["nacimiento"]));
			}
			
			$obj->ubigeo = isset($entity["ubigeo_nacimiento"])? $entity["ubigeo_nacimiento"] : null;
			$obj->ubigeo_dir = isset($entity["lugar_nacimiento"])? $entity["lugar_nacimiento"] : null;
			if (isset($entity["estado_civil"])) {
				$obj->edo_civil = $entity["estado_civil"];
			}
			if (isset($entity["madre"])) {
				$obj->nombre_mad = $entity["madre"];
			}
			if (isset($entity["padre"])) {
				$obj->nombre_pat = $entity["padre"];
			}
			if (isset($entity["direccion"]) && $entity["direccion"] !="") {
				$obj->direccion = $entity["direccion"];
			}
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
			$obj = Reniec::where("documento", $document)->first();
			if (is_null($obj)) {
				$obj = new Reniec;
				$obj->documento = $document;
				$obj->created_at = date("Y-m-d H:i:s");
			}
			$obj->apellido_pat = isset($entity["paterno"])? $entity["paterno"] : "";
			$obj->apellido_mat = isset($entity["materno"])? $entity["materno"] : "";
			$obj->nombre = isset($entity["nombres"])? $entity["nombres"] : "";
			if (isset($entity["sexo"]) && $entity["sexo"] !="" && is_numeric($entity["sexo"]) ) {
				$obj->sexo = $entity["sexo"];
			}
			if (isset($entity["nacimiento"])) {
				$obj->fec_nac = date("d/m/Y", strtotime($entity["nacimiento"]));
			}
			
			$obj->ubigeo = isset($entity["lugar_nacimiento"])? $entity["lugar_nacimiento"] : null;
			$obj->ubigeo_dir = isset($entity["ubigeo"])? $entity["ubigeo"] : null;
			if (isset($entity["estado_civil"])) {
				$obj->edo_civil = substr($entity["estado_civil"], 0, 9);
			}
			if (isset($entity["madre"])) {
				$obj->nombre_mad = $entity["madre"];
			}
			if (isset($entity["padre"])) {
				$obj->nombre_pat = $entity["padre"];
			}
			if (isset($entity["direccion"]) && $entity["direccion"] !="") {
				$obj->direccion = $entity["direccion"];
			}
			$obj->updated_at = date("Y-m-d H:i:s");
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()."\n\n Error Trace String : ".$e->getTraceAsString()];
		}
	}
}