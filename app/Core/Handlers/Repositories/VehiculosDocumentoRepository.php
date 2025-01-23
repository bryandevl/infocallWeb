<?php namespace App\Core\Handlers\Repositories;

use App\Core\Handlers\VehiculosDocumentoInterface;
use App\Models\VehiculosDocumento;
use DB;

class VehiculosDocumentoRepository implements VehiculosDocumentoInterface
{
	public function saveBD($entity = [], $entityId = null) {
		DB::beginTransaction();
		try {
			$obj = VehiculosDocumento::where("documento", $entity["documento"])
				->where("placa", strtoupper($entity["placa"]))
				->first();
			$traceObj = [
				"action_type"		=>	"",
				"process_source"	=>	"VEHICULOS_DOCUMENTO",
				"document"			=>	$entity["documento"]
			];
			if (is_null($obj)) {
				$obj = new VehiculosDocumento;
				$obj->setPrimaryKey("id");
				$obj->documento = $entity["documento"];
				$obj->placa = $entity["placa"];
				$obj->validata_created_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "CREATE";
				$traceObj["value_create"] = json_encode($entity);
			} else {
				$obj->setPrimaryKey("id");
				$obj->validata_updated_at = date("Y-m-d H:i:s");
				$traceObj["action_type"] = "UPDATE";
				$traceObj["value_update"] = json_encode($entity);
			}
			$obj->marca = strtoupper($entity["marca"]);
			$obj->modelo = strtoupper($entity["modelo"]);
			$obj->clase = strtoupper($entity["clase"]);
			$obj->fabricacion = strtoupper($entity["fabricacion"]);
			$obj->marca = strtoupper($entity["marca"]);
			$obj->compra = strtoupper($entity["compra"]);
			$obj->numero_transferencia = strtoupper($entity["nrotransferencia"]);
			$obj->tipo = strtoupper($entity["tipo"]);
			$obj->segundo_documento = strtoupper($entity["documento2"]);
			$obj->segundo_nombrecompleto = strtoupper($entity["nombrecompleto2"]);
			$obj->tipo_propiedad = strtoupper($entity["tipodepropiedad"]);
			$obj->save();
			DB::commit();
			return ["rst" => 1, "obj" => $obj, "trace" => $traceObj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD: ".$e->getMessage()];
		}
	}
}