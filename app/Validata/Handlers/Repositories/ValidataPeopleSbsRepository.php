<?php namespace App\Validata\Handlers\Repositories;

use App\Validata\Handlers\ValidataPeopleSbsInterface;
use App\Validata\Models\ValidataPeopleSbs;
use App\Validata\Models\ValidataPeopleSbsDetail;
use App\Helpers\CoreHelper;
use DB;

class ValidataPeopleSbsRepository implements ValidataPeopleSbsInterface
{
	public function saveBD($entity = [], $entityId = null) {
		$obj = ValidataPeopleSbs::where("validata_people_id", $entityId)
			->where("report_date", date("Y-m-d", strtotime($entity["fecha_reporte_sbs"])))
			->first();
		try {
			DB::beginTransaction();
			if (is_null($obj)) {
				$obj = new ValidataPeopleSbs;
				$obj->validata_people_id = $entityId;
				$obj->report_date = date("Y-m-d", strtotime($entity["fecha_reporte_sbs"]));
				$obj->company_quantity = (int)$entity["cant_empresas"];
				$obj->normal_rating = $entity["calificacion_normal"];
				$obj->cpp_rating = $entity["calificacion_cpp"];
				$obj->deficient_rating = $entity["calificacion_deficiente"];
				$obj->uncertain_rating = $entity["calificacion_dudoso"];
				$obj->lost_rating = $entity["calificacion_perdida"];
				$obj->save();
			}
			foreach ($entity["sbs_detalle"] as $key => $value) {
				$objDetail = ValidataPeopleSbsDetail::where([
					"validata_people_sbs_id"=>	$obj->id,
					"entity"				=>	strtoupper($value["entidad"]),
					"credit_type"			=>	(is_null($value["tipo_credito"]) || $value["tipo_credito"] == "")? 'OTROS' : strtoupper($value["tipo_credito"]),
					"amount"				=>	$value["monto"]
				])->first();

				if (is_null($objDetail)) {
					$objDetail = new ValidataPeopleSbsDetail;
					$objDetail->validata_people_sbs_id = $obj->id;
					$objDetail->entity = strtoupper($value["entidad"]);
					$objDetail->credit_type = (is_null($value["tipo_credito"]) || $value["tipo_credito"] == "")? 'OTROS' : strtoupper($value["tipo_credito"]);
					$objDetail->credit_type_detail = strtoupper($value["detalle"]);
					$objDetail->amount = (double)$value["monto"];
					$objDetail->days_late = (int)$value["dias_atraso"];
					$objDetail->save();
				} else {
					if (is_null($objDetail->credit_type_detail)) {
						$objDetail->credit_type_detail = strtoupper($value["detalle"]);
						$objDetail->save();
					} else {
						if ($objDetail->credit_type_detail != strtoupper($value["detalle"])) {
							$objDetail = new ValidataPeopleSbsDetail;
							$objDetail->validata_people_sbs_id = $obj->id;
							$objDetail->entity = strtoupper($value["entidad"]);
							$objDetail->credit_type = strtoupper($value["tipo_credito"]);
							$objDetail->credit_type_detail = strtoupper($value["detalle"]);
							$objDetail->amount = (double)$value["monto"];
							$objDetail->days_late = (int)$value["dias_atraso"];
							$objDetail->save();
						}
					}
				}
				$objDetail->days_late = (int)$value["dias_atraso"];
				$objDetail->save();

				CoreHelper::createFinanceEntity($value["entidad"]);
                CoreHelper::createCreditType($value["detalle"]);
			}
			DB::commit();
			return ["rst" => 1, "obj" => $obj];
		} catch (Exception $e) {
			DB::rollback();
			return ["rst" => 2, "msj" => "Error BD : ".$e->getMessage()];
		}
	}
}