<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\EmpresasDocumentoInterface;
use App\Models\EmpresasDocumento;
use DB;

class EmpresasDocumentoRepository implements EmpresasDocumentoInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = EmpresasDocumento::where("documento", $entity["documento"])
				->where("ruc", strtoupper($entity["ruc"]))
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"EMPRESAS_DOCUMENTO",
				"document"			=>	$entity["ruc"]
			];
			if (is_null($obj)) {
				$obj = new EmpresasDocumento;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->ruc = $entity["ruc"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->razonsocial = strtoupper($entity["razonsocial"]);
			$obj->nombrecomercial = strtoupper($entity["nombrecomercial"]);
			$obj->tipo = strtoupper($entity["tipo"]);
			if (!empty($entity["fecha_inscripcion"]) && $entity["fecha_inscripcion"] !="0000-00-00") {
				$obj->fecha_inscripcion =date("Y-m-d", strtotime($entity["fecha_inscripcion"]));
			}
			
			$obj->estado = strtoupper($entity["estado"]);
			if (!empty($entity["fecha_baja"]) && $entity["fecha_baja"] !="0000-00-00") {
				$obj->fecha_baja = date("Y-m-d", strtotime($entity["fecha_baja"]));
			}
			$obj->condicion = strtoupper($entity["condicion"]);
			$obj->giro = strtoupper($entity["giro"]);
			$obj->ubigeo = $entity["ubigeo"];
			$obj->direccion = strtoupper($entity["direccion"]);
			$obj->distrito = strtoupper($entity["distrito"]);
			$obj->provincia = strtoupper($entity["provincia"]);
			$obj->departamento = strtoupper($entity["departamento"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}