<?php namespace App\Console\Commands\Validata;

use Illuminate\Console\Command;
use App\FrAsignacion;
use App\Helpers\ValidataHelper;
use App\Validata\Models\ValidataLog;
use App\Validata\Models\ValidataLogDetail;
use App\Master\Handlers\FrAsignacionListInterface;
use App\Jobs\ValidataProcessDocument;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Helpers\CoreHelper;
use Log;

class ValidataSource extends Command
{
    protected $signature = "
        validata:source
            {--active=}
            {--action=}
            {--validate_exists_month=}
            {--update_send_process=}
            {--update_cactivo=}
            {--validata_log_id=}
            {--calculate_total_month_sbs=}
            {--document=}
            {--period=}
            {--limit=}";

    protected $description = 'Consulta de Fuente de Datos de Documentos';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        FrAsignacionListInterface $frAsignacionListInterface
    ) {
        $active = !is_null($this->option("active"))? $this->option("active") : 1;
        $action = !is_null($this->option("action"))? $this->option("action") : "";
        $document = !is_null($this->option("document"))? $this->option("document") : "";
        $period = !is_null($this->option("period"))? $this->option("period") : "";
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 100;
        $validataLogId = !is_null($this->option("validata_log_id"))? $this->option("validata_log_id") : null;
        $validateExistsMonth = !is_null($this->option("validate_exists_month"))? $this->option("validate_exists_month") : true;
        $updateSendProcess = !is_null($this->option("update_send_process"))? $this->option("update_send_process") : true;
        $updateCActivo = !is_null($this->option("update_cactivo"))? $this->option("update_cactivo") : true;
        $calculateTotalMonthSbs = !is_null($this->option("calculate_total_month_sbs"))? $this->option("calculate_total_month_sbs") : true;

        switch ($action) {
            case "extract":
                $timeStartExtract = date("Y-m-d H:i:s");
                $codeLog = "VD_".time();
                
                Log::channel('validata')->info("[VALIDATA][EXTRACT]---------------------------------------");
                Log::channel('validata')->info("[VALIDATA][0.]DOCUMENT'S EXTRACT TO PROCESS");
                Log::channel('validata')->info("[VALIDATA]]1.]EXTRACT START:".$timeStartExtract);
                Log::channel('validata')->info("[VALIDATA][2.]CODE LOG:".$codeLog);

                //Registrando Log de Procesamiento
                $whereTmp = [
                    "equals" => [],
                    "raw" => []
                ];
                if ($active == 1) {
                    $whereTmp["raw"][] = "cACTIVO IS NULL";
                    $whereTmp["equals"]["cSendProcess"] = 0;
                } else {
                    $whereTmp["equals"]["cACTIVO"] = (string)$active;
                    $whereTmp["equals"]["cSendProcess"] = 1;
                }
                if ($document !="") {
                    $whereTmp["equals"]["cNUM_DOCUMENTO"] = $document;
                }
                if ($period !="") {
                    $whereTmp["equals"]["cPERIODO"] = $period;
                }
                $frAsignacionList = $frAsignacionListInterface->list($whereTmp)
                    ->select(["cNUM_DOCUMENTO", "cACTIVO", "dFEC_MODIFICA", "campaign_id", "cPERIODO"])
                    ->limit($limit)
                    ->offset(0)
                    ->get()
                    ->toArray();
                $totalRecords = count($frAsignacionList);
                Log::channel('validata')->info("[VALIDATA][3.]TOTAL REQUESTS:".$totalRecords);

                $totalRecordsReal = 0;
                if ($totalRecords > 0) {
                    $objLog = new ValidataLog;
                    $objLog->code = $codeLog;
                    $objLog->time_start = $timeStartExtract;
                    $objLog->save();

                    $itemIndex = 1;
                    $cantidadDuplicadosPeriodo = 0;
                    $chunkFrAsignacionList = array_chunk($frAsignacionList, 100);
                    foreach ($chunkFrAsignacionList as $key => $value) {
                        $insertArray = [];
                        foreach ($value as $key2 => $value2) {
                            $validataLogDetailExists = null;
                            if ($validateExistsMonth!=false && $validateExistsMonth!="false") {
                                $validataLogDetailExists = ValidataLogDetail::where([
                                    "document"      =>  $value2["cNUM_DOCUMENTO"],
                                    "campaign_id"   =>  $value2["campaign_id"],
                                    'period'        =>  $value2["cPERIODO"]
                                ])->whereIn("status", ["PROCESS", "ONQUEUE"])
                                ->first();
                            }
                            
                            if (is_null($validataLogDetailExists)) {
                                $insertArray[] = [
                                    "validata_log_id"   =>  $objLog->id,
                                    "document"          =>  $value2["cNUM_DOCUMENTO"],
                                    "campaign_id"       =>  $value2["campaign_id"],
                                    "period"            =>  $value2["cPERIODO"],
                                    "status"            =>  "REGISTER",
                                    "created_at"        =>  date("Y-m-d H:i:s")
                                ];
                                $totalRecordsReal++;
                                Log::channel('validata')->info("[VALIDATA][2.".$value2["cNUM_DOCUMENTO"]."] REGISTRADO EN validata_log_detail");
                            } else {
                                $updateTmp = [
                                    "cACTIVO"       => 0
                                ];
                                if ($updateSendProcess) {
                                    $updateTmp["cSendProcess"] = 1;
                                }
                                FrAsignacion::where([
                                    "cNUM_DOCUMENTO"    =>  $value2["cNUM_DOCUMENTO"],
                                    "campaign_id"       =>  $value2["campaign_id"],
                                    "cPERIODO"          =>  $value2["cPERIODO"]
                                ])->update($updateTmp);
                                $cantidadDuplicadosPeriodo++;

                                Log::channel('validata')->info("[VALIDATA][2.".$value2["cNUM_DOCUMENTO"]."] VALORES A ACTUALIZAR : ".json_encode($updateTmp));
                            }
                        }
                        ValidataLogDetail::insert($insertArray);
                        
                        foreach ($insertArray as $key2 => $value2) {
                            @$value2["cNUM_DOCUMENTO"] = $value2["document"];
                            CoreHelper::createSbsDetailTmpTable($value2["period"]);
                            $responseSbsDetailTmp = CoreHelper::saveSbsDetailTmp($value2["period"], $value2);
                            Log::channel('validata')->info("[VALIDATA][3.{$itemIndex}]SBS DETAIL TMP RESPONSE:".$responseSbsDetailTmp);
                            $itemIndex++;
                            $updateTmp = [];
                            if ($updateSendProcess == true) {
                                $updateTmp["cSendProcess"] = 1;
                            }
                            FrAsignacion::where([
                                "cNUM_DOCUMENTO"    =>  $value2["cNUM_DOCUMENTO"],
                                "campaign_id"       =>  $value2["campaign_id"],
                                "cPERIODO"          =>  $value2["period"]
                            ])->update($updateTmp);

                            Log::channel('validata')->info("[VALIDATA][2.".$value2["document"]."] VALORES A ACTUALIZAR : ".json_encode($updateTmp));
                        }
                    }
                    $objLog->requests_total = $totalRecordsReal;
                    $objLog->duplicate_total_on_period = $cantidadDuplicadosPeriodo;
                    $objLog->save();
                }

                Log::channel('validata')->info("[VALIDATA]]4.]EXTRACT END:".date("Y-m-d H:i:s"));
                Log::channel('validata')->info("[VALIDATA][EXTRACT]---------------------------------------");
                break;

            case "queue-set":
                Log::channel('validata')->info("[VALIDATA][QUEUE-SET]---------------------------------------");
                Log::channel('validata')->info("[VALIDATA]]1.]START SET TO QUEUE:".date("Y-m-d H:i:s"));

                $documentsPending = ValidataLogDetail::from("validata_log_detail")
                    ->select(
                        "validata_log_detail.id AS id",
                        "validata_log_detail.document AS document",
                        "validata_log_detail.status AS status",
                        "validata_log_detail.job_id",
                        "validata_log_detail.validata_log_id AS validata_log_id"
                    )->leftJoin(
                        "validata_log AS vl",
                        "vl.id",
                        "=",
                        "validata_log_detail.validata_log_id"
                    )->whereRaw("vl.time_end IS NULL")
                        ->whereRaw("vl.deleted_at IS NULL")
                        ->where("status", "REGISTER")
                        ->whereRaw("job_id IS NULL")
                        ->limit($limit)->offset(0);
                    if (!is_null($validataLogId)) {
                        $documentsPending = $documentsPending->where("validata_log_detail.validata_log_id", $validataLogId);
                    }
                    $documentsPending = $documentsPending->get()->toArray();

                Log::channel('validata')->info("[VALIDATA]]2.]INGRESAN A COLA QUERY:".count($documentsPending));
                $index = 0;
                $documentsPendingGroup = [];
                $documentsPendingCount = [];
                foreach ($documentsPending as $key => $value) {
                    $validataLogId = $value["validata_log_id"];
                    $validataLogDetailId = $value["id"];

                    if (!isset($documentsPendingGroup[$validataLogId])) {
                        $documentsPendingGroup[$validataLogId] = [];
                    }
                    $documentsPendingGroup[$validataLogId][] = $value;

                    if (!isset($documentsPendingCount[$validataLogId])) {
                        $documentsPendingCount[$validataLogId] = 0;
                    }
                    $documentsPendingCount[$validataLogId]++;
                }

                foreach ($documentsPendingGroup as $key => $value) {
                    $validataLogId  = $key;
                    foreach ($value as $key2 => $value2) {
                        $isLatestRecord = false;
                        if ($documentsPendingCount[$validataLogId] <=1) {
                            $isLatestRecord = true;
                        }
                        ValidataLogDetail::where("id", $value2["id"])
                            ->update(["status" => "ONQUEUE"]);
                        
                        $job = (new ValidataProcessDocument(
                            $value2,
                            $isLatestRecord,
                            $validateExistsMonth,
                            $updateCActivo,
                            $calculateTotalMonthSbs
                        ))->onQueue('validata:process_document');
                        $jobId = dispatch($job);

                        Log::channel('validata')->info("[VALIDATA]]3.]COLOCADO A LA COLA:".$value2["document"]);
                        $documentsPendingCount[$validataLogId] = $documentsPendingCount[$validataLogId] - 1;
                    }
                }
                Log::channel('validata')->info("[VALIDATA]]4.]END SET TO QUEUE:".date("Y-m-d H:i:s"));
                Log::channel('validata')->info("[VALIDATA][QUEUE-SET]---------------------------------------");
                break;
            default:
                break;
        }
    }
}
