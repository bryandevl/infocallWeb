<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\EmpresaInterface;
use App\Master\Models\Empresa;
use DB;

class EmpresaRepository implements EmpresaInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = Empresa::where("ruc", strtoupper($entity["ruc"]))->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"EMPRESAS",
				"document"			=>	$entity["ruc"]
			];
			if (is_null($obj)) {
				$obj = new Empresa;
				$obj->ruc = $entity["ruc"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$obj->save();
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->razonsocial = strtoupper($entity["razonsocial"]);
			$obj->giro = strtoupper($entity["giro"]);
			$obj->ubigeo = $entity["ubigeo"];
			$obj->direccion = strtoupper($entity["direccion"]);
			$obj->distrito = strtoupper($entity["distrito"]);
			$obj->departamento = strtoupper($entity["departamento"]);
			$obj->provincia = strtoupper($entity["provincia"]);
			$obj->save();

			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}