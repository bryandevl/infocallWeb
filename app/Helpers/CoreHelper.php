<?php namespace App\Helpers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Helpers\ValidataHelper;
use App\Master\Models\SbsDetalleTmp;
use App\Master\Models\FinanceEntity;
use App\Master\Models\CreditType;

class CoreHelper
{
    public static function createFinanceEntity($financeEntity) {
        $financeEntityObj = FinanceEntity::where("description", strtoupper($financeEntity))->first();
        if (is_null($financeEntityObj)) {
            $financeEntityObj = new FinanceEntity;
            $financeEntityObj->description = strtoupper($financeEntity);
            $financeEntityObj->save();
        }
    }
    public static function createCreditType($creditType) {
        $creditTypeObj = CreditType::where("description", strtoupper($creditType))->first();
        if (is_null($creditTypeObj)) {
            $creditTypeObj = new CreditType;
            $creditTypeObj->description = strtoupper($creditType);
            $creditTypeObj->save();
        }
    }
	public static function saveSbsDetalleTmpRecord($recordData = [], $classBtnRating = "") {
		if (isset($recordData["document"])) {
			$objSbsTmp = SbsDetalleTmp::where([
                "finance_entity"	=>  $recordData["entity"],
                "credit_type"		=>  $recordData["credit_type"],
                "documento"         =>  $recordData["document"],
                "fec_reporte"       =>  $recordData["report_date"],
                "monto"             =>  $recordData["amount"]
            ])->first();

            if (is_null($objSbsTmp)) {
                $objSbsTmp = new SbsDetalleTmp;
                $objSbsTmp->finance_entity = $recordData["entity"];
                $objSbsTmp->credit_type = $recordData["credit_type"];
                $objSbsTmp->documento = $recordData["document"];
                $objSbsTmp->fec_reporte = $recordData["report_date"];
                $objSbsTmp->condicion = ValidataHelper::getCondicionPeopleByClassBtn($classBtnRating);
                $objSbsTmp->credit_type_detail = strtoupper($recordData["credit_type_detail"]);
                $objSbsTmp->monto = $recordData["amount"];
                $objSbsTmp->save();
            } else {
                if (is_null($objSbsTmp->credit_type_detail)) {
                    $objSbsTmp->credit_type_detail = strtoupper($recordData["credit_type_detail"]);
                    $objSbsTmp->save();
                } else {
                    if ($objSbsTmp->credit_type_detail != strtoupper($recordData["credit_type_detail"])) {
                        $objSbsTmp = new SbsDetalleTmp;
                        $objSbsTmp->finance_entity = strtoupper($recordData["entity"]);
                        $objSbsTmp->credit_type = strtoupper($recordData["credit_type"]);
                        $objSbsTmp->documento = $recordData["document"];
                        $objSbsTmp->fec_reporte = $recordData["report_date"];
                        $objSbsTmp->credit_type_detail = strtoupper($recordData["credit_type_detail"]);
                        $objSbsTmp->condicion = ValidataHelper::getCondicionPeopleByClassBtn($classBtnRating);
                        $objSbsTmp->monto = $recordData["amount"];
                        $objSbsTmp->save();
                    }
                }
            }
            $objSbsTmp->credit_type_detail = $recordData["credit_type_detail"];
            $objSbsTmp->save();
		}
	}

	public static function saveSbsDetailTmp(
		$cPeriodo = "", $record = []
	) {
		if ($cPeriodo !="") {
			DB::beginTransaction();
			try {
				$tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
				$recordExists = DB::table($tableSbsTmp)
					->where([
                        "num_documento" =>  $record["cNUM_DOCUMENTO"],
                        "campaign_id"   =>  $record["campaign_id"]
                    ])->first();
                if (is_null($recordExists)) {
                	DB::table($tableSbsTmp)
						->insert([
	                        "num_documento" => $record["cNUM_DOCUMENTO"],
	                        "created_at" => date("Y-m-d H:i:s"),
	                        "campaign_id" => $record["campaign_id"]
	                    ]);
				}
				DB::commit();
				return true;
			} catch (Exception $e) {
				DB::rollback();
				return $e->getMessage();
			}
		}
		return false;
	}

	public static function createSbsDetailTmpTable($cPeriodo = "") {
		if ($cPeriodo !="") {
			$tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
			if (!Schema::hasTable($tableSbsTmp)) {
                try {
                    Schema::create(
                        $tableSbsTmp,
                        function (Blueprint $table) {
                            $table->bigIncrements('id');
                            $table->string('num_documento', 20)->nullable();
                            $table->string('campaign_id', 20)->nullable();
                            $table->enum('status', ['REGISTER', 'ONPROCESS', 'COMPLETED', 'NOPROCESS'])
                                ->default('REGISTER');

                            $table->dateTime('created_at')->nullable();
                            $table->dateTime('updated_at')->nullable();
                            $table->dateTime('deleted_at')->nullable();
                        }
                    );
                    return true;
                } catch (Exception $e) {
                    return false;
                }
			}
			return true;
		}
		return false;
	}

	public static function mergeSbsDetailTmpRecord($record = []) {
		$updateTmp = [];
        $updateTmp["fec_cruce"] = date("Y-m-d H:i:s");
        if ($record["monto"] > 0) {
            $creditType = $record["credit_type"];
            $entity = $record["finance_entity"];
            $creditTypeLabelTmp = "";
            $financeEntityBD = FinanceEntity::where("description", strtoupper($entity))->first();

            switch ($creditType) {
            	case 'COMERCIAL':
            		$creditTypeLabelTmp = "saldo_cast_ref";
                    break;
                case 'CONVENIO':
                	$creditTypeLabelTmp = "saldo_con_otros";
                    break;
                case 'HIPOTECARIO':
                	$creditTypeLabelTmp = "saldo_hip_veh";
                    break;
                case 'PRESTAMO':
                    $creditTypeLabelTmp = "saldo_con_otros";
                    break;
                case 'TARJETA':
                	$creditTypeLabelTmp = "saldo_tc";
                    break;
                case 'VEHICULAR':
                    $creditTypeLabelTmp = "saldo_hip_veh";
                    break;
                case 'OTROS':
                	$creditTypeLabelTmp = "saldo_con_otros";
                    break;
                default:
                	break;
            }

            if ($creditTypeLabelTmp!="") {
                $updateTmp[$creditTypeLabelTmp] = $record["monto"];
                switch ($entity) {
                	case 'BANCO CENCOSUD':
                		$updateTmp[$creditTypeLabelTmp."_cnc"] = $record["monto"];
                        break;
                    case 'BANCO FALABELLA':
                        $updateTmp[$creditTypeLabelTmp."_fal"] = $record["monto"];
                        break;
                    case "BANCO INTERNACIONAL DEL PERU VENTA DE CARTERA":
                    case "INTERBANK":
                        $updateTmp[$creditTypeLabelTmp."_ibk"] = $record["monto"];
                        break;
                    default:
                    	break;
                }
        	}

        	if (!is_null($financeEntityBD)) {
                switch ($financeEntityBD->flag_type) {
                    case 'BANCO':
                    	$updateTmp["saldo_banco"] = $record["monto"];
                        break;
                    case 'CAJA_EDPYME_OTROS':
                        $updateTmp["saldo_caja_otros"] = $record["monto"];
                        break;
                    case 'FINANCIERA':
                    	$updateTmp["saldo_financiera"] = $record["monto"];
                        break;
                    default:
                    	break;
                }
            }
        }
        SbsDetalleTmp::where(["id" => $record["id"]])
        	->update($updateTmp);
	}
    public static function isRuc($document = "") {
        if ((int)$document > 10000000000) {
            return true;
        }
        return false;
        /*if ((int)strlen($document) > 8) {
            return true;
        }
        return false;*/
    }
    public static function isDni($document = "") {
        if ((int)$document > 100000000) {
            return false;
        }
        return true;
    }
    public static function isFijo($phone = "") {
        if (strlen($phone) < 9) {
            if ($phone > 2147483647) {
                return false;
            }
            return true;
        }
        return false;
    }
    public static function isCelular($phone = "") {
        if (strlen($phone) >= 9) {
            return true;
        }
        return false;
    }
    public static function getTipoFamiliar($tipoFamiliar = "") {
        switch ($tipoFamiliar) {
            case "H":
                return "HIJO";
                break;
            case "C":
                return "CONYUGE";
                break;
            default:
                break;
        }
        return $tipoFamiliar;
    }

    public static function guidv4($data = null) {
        // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);

        // Set version to 0100
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        // Set bits 6-7 to 10
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        // Output the 36 character UUID.
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}