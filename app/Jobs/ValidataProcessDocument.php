<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Validata\Models\ValidataLogDetail;
use App\Validata\Models\ValidataPeopleSbs;
use App\Api\Client\ClientRestFulApi;
use App\Jobs\ValidataRegisterTables;
use App\Jobs\UpdateSourceTables;
use Log;

class ValidataProcessDocument implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_requestDetail;
    protected $_isLatestRecord;
    protected $_validateExistsMonth;
    protected $_updateCActivo;
    protected $_calculateTotalMonthSbs;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $requestDetail = [],
        $isLatestRecord = false,
        $validateExistsMonth = true,
        $updateCActivo = true,
        $calculateTotalMonthSbs = true
    ) {
        $this->_requestDetail = $requestDetail;
        $this->_isLatestRecord = $isLatestRecord;
        $this->_validateExistsMonth = $validateExistsMonth;
        $this->_updateCActivo = $updateCActivo;
        $this->_calculateTotalMonthSbs = $calculateTotalMonthSbs;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $jobId = $this->job->getJobId();
        $request = $this->_requestDetail;
        $objDetail = ValidataLogDetail::with(["people", "people.sbs", "people.sbsLatest"])->find($request["id"]);
        
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}]---------------------------------------");
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][0.]START:".date("Y-m-d H:i:s"));
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][1.]JOBID:".$jobId);
            Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][2.]ID:".$request["id"]);
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][3.]STATUS: {$objDetail->status}");

        
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][3.1.]DOCUMENT:".$objDetail->document);

        if (in_array($objDetail->status, ["REGISTER", "ONQUEUE"])) {
            $documentProcessOnMonth = null;
            if ($this->_validateExistsMonth!=false && $this->_validateExistsMonth!="false") {
                $documentProcessOnMonth = 
                ValidataLogDetail::select("*")
                    ->where("document", $objDetail->document)
                    ->whereRaw("MONTH(created_at) = MONTH(NOW())")
                    ->whereRaw("YEAR(created_at) = YEAR(NOW()) ")
                    ->where("status", "PROCESS")
                    ->first();
            }

            $objDetail->job_id = $jobId;
            $objDetail->save();

            if (is_null($documentProcessOnMonth)) {
                $enviroment = strtolower(env("APP_ENV", "production"));
                $clientRestFul = new ClientRestFulApi;
                $urlEndpoint = "";
                if (strlen($objDetail->document) <=8) {
                    $urlEndpoint = \Config::get("validata.api.endpoint.{$enviroment}");
                } else {
                    $urlEndpoint = \Config::get("validata.api.endpoint_empresa.{$enviroment}");
                }
                
                $urlEndpoint.="&documento=".$objDetail->document;

                $meses = 12;
                if ($this->_calculateTotalMonthSbs == true) {
                    if (!is_null($objDetail->people)) {
                        if (count($objDetail->people->sbs) < 12) {
                            $meses = (12 - count($objDetail->people->sbs));
                            Log::channel('validata:process_document')
                                ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][3.2]MESES REQUEST API:".$meses);
                        } else {
                            $sbsLatest = $objDetail->people->sbs_latest;
                            if (!is_null($sbsLatest)) {
                                $latestReport = $sbsLatest->report_date." 00:00:00";
                                $now = date("Y-m-d")." 23:59:59";
                                $interval = (new \DateTime($latestReport))->diff(new \DateTime($now));
                                $meses = $interval->format("%m")+($interval->format("%y")*12);
                                if ($meses > 12) {
                                    $meses = 12;
                                }
                            }
                            Log::channel('validata:process_document')
                                ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][3.2]MESES REQUEST API:".$meses);
                        }
                    }
                }
                
                $urlEndpoint.="&meses=".$meses;
                $clientRestFul->setUrlEndpoint($urlEndpoint);
                $clientRestFul->setType("GET");
                $clientRestFul->doAction();
                $responseArray = json_decode($clientRestFul->getResponse(), true);
                Log::channel('validata:process_document')
                    ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][4.]REQUEST API:".$clientRestFul->getUrlEndpoint());
                Log::channel('validata:process_document')
                    ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][4.]RESPONSE API:".$clientRestFul->getResponse());

                if (!isset($responseArray["curl_error"])) {
                    if (isset($responseArray["status"])) {
                        if (strtoupper($responseArray["status"]) == "OK") {
                            $job = (new ValidataRegisterTables(
                                $responseArray["data"],
                                $request["id"],
                                $this->_isLatestRecord,
                                $objDetail->campaign_id,
                                $this->_updateCActivo
                            ))->onQueue('validata:register_tables');
                            $jobId = dispatch($job);

                            $jobSource = (new UpdateSourceTables(
                                $responseArray["data"],
                                $request["id"]
                            ))->onQueue('validata:update_source')->delay(now()->addSeconds(3));
                            $jobSourceId = dispatch($jobSource);

                            $objDetail->status = "PROCESS";
                            $objDetail->save();

                            Log::channel('validata:process_document')
                                ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA RETORNA INFORMACIÓN");
                        }
                        if (strtoupper($responseArray["status"]) == "ERROR") {
                            $job = (new ValidataRegisterTables(
                                [],
                                $request["id"],
                                $this->_isLatestRecord,
                                $objDetail->campaign_id,
                                $this->_updateCActivo
                            ))->onQueue('validata:register_tables');
                            $jobId = dispatch($job);

                            $objDetail->status = "NOTDATA";
                            $objDetail->save();

                            Log::channel('validata:process_document')
                                ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA RETORNA ERROR");
                        }
                    } else {
                        $job = (new ValidataRegisterTables(
                            [],
                            $request["id"],
                            $this->_isLatestRecord,
                            $objDetail->campaign_id,
                            $this->_updateCActivo
                        ))->onQueue('validata:register_tables');
                        $jobId = dispatch($job);

                        $objDetail->status = "NOTDATA";
                        $objDetail->save();

                        Log::channel('validata:process_document')
                            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA NO TIENE INFORMACIÓN");
                    }
                } else {
                    $job = (new ValidataRegisterTables(
                        [],
                        $request["id"],
                        $this->_isLatestRecord,
                        $objDetail->campaign_id,
                        $this->_updateCActivo
                    ))->onQueue('validata:register_tables')->delay(now()->addSeconds(3));
                    $jobId = dispatch($job);
                    $objDetail->status = "FAILED";
                    $objDetail->save();

                    Log::channel('validata:process_document')
                        ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][5.]CURL ERROR:".$responseArray["curl_error"]);
                }
            } else {
                $objDetail->status = "REPEAT";
                $objDetail->save();

                $job = (new ValidataRegisterTables(
                    [],
                    $request["id"],
                    $this->_isLatestRecord
                ))->onQueue('validata:register_tables');
                $jobId = dispatch($job);
                
                Log::channel('validata:process_document')
                    ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][5.1.] YA EXISTE ESTE DOCUMENTO EN EL PROCESAMIENTO DE ESTE MES");
            }
        }
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}][6.]END:".date("Y-m-d H:i:s"));
        Log::channel('validata:process_document')
            ->info("[VALIDATA:PROCESSDOCUMENT][{$objDetail->document}]---------------------------------------");
    }
}
