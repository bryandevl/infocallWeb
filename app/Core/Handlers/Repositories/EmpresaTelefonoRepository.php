<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\EmpresaTelefonoInterface;
use App\Models\EmpresaTelefono;
use DB;

class EmpresaTelefonoRepository implements EmpresaTelefonoInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = EmpresaTelefono::where("ruc", $entity["documento"])
				->where("numero", $entity["telefono"])
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"EMPRESA_TELEFONO",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new EmpresaTelefono;
				$obj->setPrimaryKey("id");
				$obj->numero = $entity["telefono"];
				$obj->ruc = $entity["documento"];
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
			$obj->razonsocial = strtoupper($entity["people"]);
			$obj->tipo = strtoupper($entity["tipo_telefono"]);
			$obj->fuente = strtoupper($entity["origen_data"]);
			
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}