<?php namespace App\Console\Commands\Validata;

use Illuminate\Console\Command;
use App\FrAsignacion;
use App\Master\Handlers\FrAsignacionListInterface;
use App\Master\Models\FinanceEntity;
use App\Validata\Models\ValidataPeopleSbs;
use App\Validata\Models\ValidataPeople;
use App\Validata\Models\ValidataLog;
use App\Validata\Models\ValidataLogDetail;
use App\Master\Models\SbsDetalleTmp;
use App\Helpers\ValidataHelper;
use App\Validata\Handlers\ValidataPeopleSbsInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Helpers\CoreHelper;
use Log;

class ValidataCruceSbsDetail extends Command
{
    protected $signature = "
        validata:cruce_sbs_detail
            {--cperiodo=}
            {--campaign_id=}
            {--action=}
            {--limit=}";

    protected $description = 'Cruce de SBS Detalle de Fuente FR_ASIGNACION';
    protected $_keyCodeCache;
    protected $_keySourceCodeCache;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_keyCodeCache = \Config::get("validata.keycache.validata_code");
        $this->_keySourceCodeCache = \Config::get("validata.keycache.source_code");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        FrAsignacionListInterface $frAsignacionListInterface,
        ValidataPeopleSbsInterface $validataPeopleSbsInterface
    ) {
        $campaignId = !is_null($this->option("campaign_id"))? $this->option("campaign_id") : "";
        $action = !is_null($this->option("action"))? $this->option("action") : "";
        $cPeriodo = !is_null($this->option("cperiodo"))? $this->option("cperiodo") : date("Ym");
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 100000;

        switch ($action) {
            case "update-validata-sbs":
                Log::channel('validata:sbs')->info("[VALIDATA][UPDATE]---------------------------------------");
                Log::channel('validata:sbs')->info("[VALIDATA][0.]DOCUMENT'S EXTRACT TO PROCESS UPDATE");
                /*$tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
                $sbsDocuments = DB::table($tableSbsTmp)
                    ->where("status", "REGISTER")
                    ->limit($limit)
                    ->offset(0)
                    ->get()
                    ->toArray();
                $sbsDocumentsGroup = array_chunk($sbsDocuments, 500);
                foreach ($sbsDocumentsGroup as $key => $value) {
                    if (count($value) > 0) {
                        $timeStartExtract = date("Y-m-d H:i:s");
                        $codeLog = "VD_".time();
                        $objLog = new ValidataLog;
                        $objLog->code = $codeLog;
                        $objLog->time_start = $timeStartExtract;
                        $objLog->save();

                        $insertArray = [];
                        $totalRecordsReal = 0;
                        $value = json_decode(json_encode($value), true);
                        foreach ($value as $key2 => $value2) {
                            $insertArray[] = [
                                "validata_log_id"   =>  $objLog->id,
                                "document"          =>  $value2["num_documento"],
                                "campaign_id"       =>  $value2["campaign_id"],
                                "status"            =>  "REGISTER",
                                "created_at"        =>  date("Y-m-d H:i:s")
                            ];
                            $totalRecordsReal++;
                            Log::channel('validata:sbs')->info("[VALIDATA][2.][DOCUMENT] ".$value2["num_documento"]);
                        }
                        ValidataLogDetail::insert($insertArray);
                        $objLog->requests_total = $totalRecordsReal;
                        $objLog->save();
                    }
                }*/
                Log::channel('validata:sbs')->info("[VALIDATA][2.]FINISH DOCUMENT'S EXTRACT TO PROCESS UPDATE");
                break;
            case "extract":
                Log::channel('validata:sbs')->info("[VALIDATA][EXTRACT]---------------------------------------");
                Log::channel('validata:sbs')->info("[VALIDATA][0.]DOCUMENT'S EXTRACT TO PROCESS");
                //Extrayendo documentos de Fuente por periodo
                /*tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
                $responseSbsDetailTmp = CoreHelper::createSbsDetailTmpTable($cPeriodo);
                Log::channel('validata:sbs')->info("[VALIDATA][1.]RESPONSE CREATE TABLE {$tableSbsTmp} :".$responseSbsDetailTmp);

                $whereTmp = [
                    "equals" => [],
                    "raw" => []
                ];
                
                $whereTmp["equals"]["cPERIODO"] = $cPeriodo;
                if ($campaignId !="") {
                    $whereTmp["equals"]["campaign_id"] = $campaignId;
                }
                $frAsignacionList = $frAsignacionListInterface->list($whereTmp)
                    ->select(["cNUM_DOCUMENTO", "cACTIVO", "dFEC_MODIFICA", "campaign_id"])
                    ->limit($limit)->offset(0)
                    ->get()->toArray();

                $chunkFrAsignacionList = array_chunk($frAsignacionList, 1000);
                foreach ($chunkFrAsignacionList as $key => $value) {
                    $insertArray = [];
                    foreach ($value as $key2 => $value2) {
                        $responseSbsDetailTmp = CoreHelper::saveSbsDetailTmp($cPeriodo, $value2);
                        Log::channel('validata:sbs')->info("[VALIDATA][2.] DOCUMENT :".$value2["cNUM_DOCUMENTO"]);
                    }
                    DB::beginTransaction();
                    try {
                        DB::table($tableSbsTmp)->insert($insertArray);
                        DB::commit();
                    } catch (Exception $e) {
                        DB::rollback();
                    }
                }*/
                Log::channel('validata:sbs')->info("[VALIDATA]]2.]EXTRACT END:".date("Y-m-d H:i:s"));
                Log::channel('validata:sbs')->info("[VALIDATA][EXTRACT]---------------------------------------");
                break;

            case "insert-record":
                Log::channel('validata:sbs')->info("[VALIDATA][INSERT-RECORD]---------------------------------------");
                Log::channel('validata:sbs')->info("[VALIDATA]]1.]START INSERT TO RECORD:".date("Y-m-d H:i:s"));

                /*if ($campaignId == "") {
                    Log::channel('validata:sbs')->info("[VALIDATA]]3.]END INSERT TO RECORD:".date("Y-m-d H:i:s"));
                    Log::channel('validata:sbs')->info("[VALIDATA][INSERT-RECORD]---------------------------------------");
                    return;
                }
                $tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
                $registerRecords = DB::table($tableSbsTmp)
                    ->where("status", "REGISTER")
                    ->where("campaign_id", $campaignId)
                    ->limit($limit)->offset(0)
                    ->pluck("num_documento", "num_documento")
                    ->toArray();

                $chunkRecords = array_chunk($registerRecords, 200);
                foreach ($chunkRecords as $key => $value) {
                    $sbsRecords = ValidataPeople::with(["sbsLatest", "sbsLatest.detail"])
                        ->whereIn("document", $value)
                        ->get()
                        ->toArray();

                    if (count($sbsRecords) > 0) {
                        foreach ($sbsRecords as $key2 => $value2) {
                            Log::channel('validata:sbs')->info("[VALIDATA]]1..]DOCUMENTO:".$value2["document"]);
                            $sbsLatest = $value2["sbs_latest"];
                            if (!is_null($sbsLatest)) {
                                $detailTmp = $sbsLatest["detail"];
                                $rating = ValidataHelper::getRatingBySbsLatest($sbsLatest);
                                $classBtnRating = ValidataHelper::getButtonClassLatest($rating);
                                foreach ($detailTmp as $key3 => $value3) {
                                    @$value3["report_date"] = $sbsLatest["report_date"];
                                    @$value3["document"] = $value2["document"];

                                    CoreHelper::saveSbsDetalleTmpRecord($value3, $classBtnRating);
                                }
                                Log::channel('validata:sbs')->info("[VALIDATA]]2..]SBS DETALLE PROCESADA:".$value2["document"]);

                                DB::table($tableSbsTmp)
                                    ->where([
                                        "num_documento" => $value2["document"],
                                        "campaign_id" => $campaignId
                                    ])->update([
                                        "status" => "ONPROCESS",
                                        "updated_at" => date("Y-m-d H:i:s")
                                    ]);
                            } else {
                                Log::channel('validata:sbs')->info("[VALIDATA]]2..]SIN INFORMACIÓN SBS RECIENTE:".$value2["document"]);
                                DB::table($tableSbsTmp)
                                    ->where([
                                        "num_documento" => $value2["document"],
                                        "campaign_id" => $campaignId
                                    ])->update([
                                        "status" => "NOPROCESS",
                                        "updated_at" => date("Y-m-d H:i:s")
                                    ]);
                            }
                        }
                    } else {
                        DB::table($tableSbsTmp)->whereIn("num_documento", $value)
                            ->where("campaign_id", $campaignId)
                            ->update(["status" => "NOPROCESS", "updated_at" => date("Y-m-d H:i:s")]);
                    }
                }*/

                Log::channel('validata:sbs')->info("[VALIDATA]]3.]END INSERT TO RECORD:".date("Y-m-d H:i:s"));
                Log::channel('validata:sbs')->info("[VALIDATA][INSERT-RECORD]---------------------------------------");
                break;
            case "run-merge":
                Log::channel('validata:sbs')->info("[VALIDATA][RUN-MERGE]---------------------------------------");
                Log::channel('validata:sbs')->info("[VALIDATA]]1.]START RUN MERGE:".date("Y-m-d H:i:s"));
                /*$tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
                $recordsOnProcess = DB::table($tableSbsTmp)
                    ->where("status", "ONPROCESS")
                    ->where("campaign_id", $campaignId)
                    ->limit($limit)->offset(0)
                    ->pluck("num_documento", "num_documento")
                    ->toArray();

                $sbsDetailRecords = SbsDetalleTmp::whereIn("documento", $recordsOnProcess)
                    ->whereRaw("fec_cruce IS NULL")
                    ->get()
                    ->toArray();
                if (count($sbsDetailRecords) > 0) {
                    $chunkRecords = array_chunk($sbsDetailRecords, 20);
                    foreach ($chunkRecords as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            CoreHelper::mergeSbsDetailTmpRecord($value2);

                            Log::channel('validata:sbs')->info("[VALIDATA]]2..]CRUCE REALIZADO DE:".$value2["documento"]);
                            Log::channel('validata:sbs')->info("[VALIDATA]]2.1..]ENTIDAD:".$value2["finance_entity"]);
                            Log::channel('validata:sbs')->info("[VALIDATA]]2.2..]TIPO CREDITO:".$value2["credit_type"]);

                            DB::table($tableSbsTmp)->where("num_documento", $value2["documento"])->update(["status" => "COMPLETED", "updated_at" => date("Y-m-d H:i:s")]);
                        }
                    }
                } else {
                    DB::table($tableSbsTmp)->whereIn("num_documento", $recordsOnProcess)
                        ->where("campaign_id", $campaignId)
                        ->update(["status" => "NOPROCESS", "updated_at" => date("Y-m-d H:i:s")]);
                }*/

                Log::channel('validata:sbs')->info("[VALIDATA]]3.]END RUN MERGE:".date("Y-m-d H:i:s"));
                Log::channel('validata:sbs')->info("[VALIDATA][RUN-MERGE]---------------------------------------");
                
                break;
            default:
                break;
        }
    }
}
