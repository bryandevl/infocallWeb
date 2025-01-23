<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\EmpresasRepresentanteInterface;
use App\Models\EmpresaRepresentantes;
use DB;

class EmpresaRepresentantesRepository implements EmpresasRepresentanteInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = EmpresaRepresentantes::where("documento", $entity["documento"])
				->where("ruc", strtoupper($entity["ruc"]))
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"EMPRESAS_REPRESENTANTES",
				"document"			=>	$entity["ruc"]
			];
			if (is_null($obj)) {
				$obj = new EmpresaRepresentantes;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->ruc = $entity["ruc"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$obj->save();
				
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->tipo_documento = strtoupper($entity["tipo_documento"]);
			$obj->nombres = strtoupper($entity["nombres"]);
			$obj->cargo = strtoupper($entity["cargo"]);
			
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}