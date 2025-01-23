<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\FrAsignacion;
use App\Serch\Models\SerchLog;
use App\Serch\Models\SerchLogDetail;
use App\Master\Handlers\FrAsignacionListInterface;
use App\Jobs\Serch\ProcessDocument;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Log;

class SerchSource extends Command
{
    protected $signature = "
        serch:source
            {--active=}
            {--action=}
            {--validate_exists_month=}
            {--update_send_process=}
            {--update_cactivo=}
            {--serch_log_id=}
            {--calculate_total_month_sbs=}
            {--document=}
            {--period=}
            {--limit=}";

    protected $description = 'Consulta de Fuente de Datos de Documentos para Serch';
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
        $period = !is_null($this->option("period"))? $this->option("period") : date("Ym");
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 100;
        $serchLogId = !is_null($this->option("serch_log_id"))? $this->option("serch_log_id") : null;
        $validateExistsMonth = !is_null($this->option("validate_exists_month"))? $this->option("validate_exists_month") : true;
        $updateSendProcess = !is_null($this->option("update_send_process"))? $this->option("update_send_process") : true;
        $updateCActivo = !is_null($this->option("update_cactivo"))? $this->option("update_cactivo") : true;
        $calculateTotalMonthSbs = !is_null($this->option("calculate_total_month_sbs"))? $this->option("calculate_total_month_sbs") : true;

        switch ($action) {
            case "extract":
                $timeStartExtract = date("Y-m-d H:i:s");
                $codeLog = "SERCH_".time();
                
                Log::channel('serch')->info("[SERCH][EXTRACT]---------------------------------------");
                Log::channel('serch')->info("[SERCH][0.]DOCUMENT'S EXTRACT TO PROCESS");
                Log::channel('serch')->info("[SERCH]]1.]EXTRACT START:".$timeStartExtract);
                Log::channel('serch')->info("[SERCH][2.]CODE LOG:".$codeLog);

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
                $frAsignacionList = 
                    $frAsignacionListInterface
                        ->list($whereTmp)
                        ->select([
                            "cNUM_DOCUMENTO",
                            "cACTIVO",
                            "dFEC_MODIFICA",
                            "campaign_id",
                            "cPERIODO"
                        ])
                        ->limit($limit)
                        ->offset(0)
                        ->get()
                        ->toArray();
                $totalRecords = count($frAsignacionList);
                Log::channel('serch')->info("[SERCH][3.]TOTAL REQUESTS:".$totalRecords);

                $totalRecordsReal = 0;
                if ($totalRecords > 0) {
                    $objLog = new SerchLog;
                    $objLog->code = $codeLog;
                    $objLog->time_start = $timeStartExtract;
                    $objLog->save();

                    $itemIndex = 1;
                    $cantidadDuplicadosPeriodo = 0;
                    $chunkFrAsignacionList = array_chunk($frAsignacionList, 100);
                    foreach ($chunkFrAsignacionList as $key => $value) {
                        $insertArray = [];
                        foreach ($value as $key2 => $value2) {
                            $serchLogDetailExists = null;
                            if ($validateExistsMonth!=false && $validateExistsMonth!="false") {
                                $serchLogDetailExists = SerchLogDetail::where([
                                    "document"      =>  $value2["cNUM_DOCUMENTO"],
                                    "campaign_id"   =>  $value2["campaign_id"],
                                    'period'        =>  $value2["cPERIODO"]
                                ])->whereIn("status", ["PROCESS", "ONQUEUE"])
                                ->first();
                            }
                            
                            if (is_null($serchLogDetailExists)) {
                                $insertArray[] = [
                                    "serch_log_id"   =>  $objLog->id,
                                    "document"          =>  $value2["cNUM_DOCUMENTO"],
                                    "campaign_id"       =>  $value2["campaign_id"],
                                    "period"            =>  $value2["cPERIODO"],
                                    "status"            =>  "REGISTER",
                                    "created_at"        =>  date("Y-m-d H:i:s")
                                ];
                                $totalRecordsReal++;
                                Log::channel('serch')->info("[SERCH][2.".$value2["cNUM_DOCUMENTO"]."] REGISTRADO EN validata_log_detail");
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

                                Log::channel('serch')->info("[SERCH][2.".$value2["cNUM_DOCUMENTO"]."] VALORES A ACTUALIZAR : ".json_encode($updateTmp));
                            }
                        }
                        SerchLogDetail::insert($insertArray);
                        
                        foreach ($insertArray as $key2 => $value2) {
                            @$value2["cNUM_DOCUMENTO"] = $value2["document"];
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

                            Log::channel('serch')->info("[SERCH][2.".$value2["document"]."] VALORES A ACTUALIZAR : ".json_encode($updateTmp));
                        }
                    }
                    $objLog->requests_total = $totalRecordsReal;
                    $objLog->duplicate_total_on_period = $cantidadDuplicadosPeriodo;
                    $objLog->save();
                }

                Log::channel('serch')->info("[SERCH]]4.]EXTRACT END:".date("Y-m-d H:i:s"));
                Log::channel('serch')->info("[SERCH][EXTRACT]---------------------------------------");
                break;

            case "queue-set":
                Log::channel('serch')->info("[SERCH][QUEUE-SET]---------------------------------------");
                Log::channel('serch')->info("[SERCH]]1.]START SET TO QUEUE:".date("Y-m-d H:i:s"));

                $documentsPending = SerchLogDetail::from("serch_log_detail")
                    ->select(
                        "serch_log_detail.id AS id",
                        "serch_log_detail.document AS document",
                        "serch_log_detail.status AS status",
                        "serch_log_detail.job_id",
                        "serch_log_detail.serch_log_id AS serch_log_id"
                    )->leftJoin(
                        "serch_log AS sl",
                        "sl.id",
                        "=",
                        "serch_log_detail.serch_log_id"
                    )->whereRaw("sl.time_end IS NULL")
                        ->whereRaw("sl.deleted_at IS NULL")
                        ->where("status", "REGISTER")
                        ->whereRaw("job_id IS NULL")
                        ->limit($limit)->offset(0);
                    if (!is_null($serchLogId)) {
                        $documentsPending = $documentsPending->where("serch_log_detail.serch_log_id", $serchLogId);
                    }
                    $documentsPending = $documentsPending->get()->toArray();

                Log::channel('serch')->info("[SERCH]]2.]INGRESAN A COLA QUERY:".count($documentsPending));
                $index = 0;
                $documentsPendingGroup = [];
                $documentsPendingCount = [];
                foreach ($documentsPending as $key => $value) {
                    $serchLogId = $value["serch_log_id"];
                    $serchLogDetailId = $value["id"];

                    if (!isset($documentsPendingGroup[$serchLogId])) {
                        $documentsPendingGroup[$serchLogId] = [];
                    }
                    $documentsPendingGroup[$serchLogId][] = $value;

                    if (!isset($documentsPendingCount[$serchLogId])) {
                        $documentsPendingCount[$serchLogId] = 0;
                    }
                    $documentsPendingCount[$serchLogId]++;
                }

                foreach ($documentsPendingGroup as $key => $value) {
                    $serchLogId  = $key;
                    foreach ($value as $key2 => $value2) {
                        $isLatestRecord = false;
                        if ($documentsPendingCount[$serchLogId] <=1) {
                            $isLatestRecord = true;
                        }
                        SerchLogDetail::where("id", $value2["id"])
                            ->update(["status" => "ONQUEUE"]);
                        
                        $job = (
                            new ProcessDocument(
                                $value2,
                                $isLatestRecord,
                                $validateExistsMonth,
                                $updateCActivo,
                                $calculateTotalMonthSbs
                            )
                        )->onQueue('serch:process_document');
                        $jobId = dispatch($job);

                        Log::channel('serch')->info("[SERCH]]3.]COLOCADO A LA COLA:".$value2["document"]);
                        $documentsPendingCount[$serchLogId] = $documentsPendingCount[$serchLogId] - 1;
                    }
                }
                Log::channel('serch')->info("[SERCH]]4.]END SET TO QUEUE:".date("Y-m-d H:i:s"));
                Log::channel('serch')->info("[SERCH][QUEUE-SET]---------------------------------------");
                break;
            default:
                break;
        }
    }
}
