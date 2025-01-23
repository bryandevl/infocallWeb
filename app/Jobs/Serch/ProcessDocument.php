<?php namespace App\Jobs\Serch;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Serch\Models\SerchLogDetail;
use App\Validata\Models\ValidataPeopleSbs;
use App\Api\Client\ClientRestFulApi;
use App\Jobs\ValidataRegisterTables;
use App\Jobs\Serch\UpdateSource;

use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchPeopleEssaludInterface;
use App\Serch\Handlers\SerchPeopleFamiliarInterface;
use App\Serch\Handlers\SerchPeopleTelefonoInterface;
use App\Serch\Handlers\SerchPeopleCorreoInterface;
use App\Serch\Handlers\SerchPeopleSbsInterface;

use Log;

class ProcessDocument implements ShouldQueue
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
    public function handle(
        SerchPeopleInfoInterface $serchPeopleInterface,
        SerchPeopleEssaludInterface $serchPeopleEssaludInterface,
        SerchPeopleFamiliarInterface $serchPeopleFamiliarInterface,
        SerchPeopleTelefonoInterface $serchPeopleTelefonoInterface,
        SerchPeopleCorreoInterface $serchPeopleCorreoInterface,
        SerchPeopleSbsInterface $SerchPeopleSbsInterface   ///////////////// modifidicacion////////////
    ) {
        $jobId = $this->job->getJobId();
        $request = $this->_requestDetail;
        $objDetail = SerchLogDetail::find($request["id"]);
        
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}]---------------------------------------");
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][0.]START:".date("Y-m-d H:i:s"));
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][1.]JOBID:".$jobId);
            Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][2.]ID:".$request["id"]);
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.]STATUS: {$objDetail->status}");

        
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.1.]DOCUMENT:".$objDetail->document);

        if (in_array($objDetail->status, ["REGISTER", "ONQUEUE"])) {
            $documentProcessOnMonth = null;
            if ($this->_validateExistsMonth!=false && $this->_validateExistsMonth!="false") {
                $documentProcessOnMonth = 
                SerchLogDetail::select("*")
                    ->where("document", $objDetail->document)
                    ->whereRaw("MONTH(created_at) = MONTH(NOW())")
                    ->whereRaw("YEAR(created_at) = YEAR(NOW()) ")
                    ->where("status", "PROCESS")
                    ->first();
            }

            $objDetail->job_id = $jobId;
            $objDetail->save();

            if ($objDetail->document == "" || empty($objDetail->document)) {
                $objDetail->status = "FAILED";
                $objDetail->save();
                $this->job->delete();
            }

            if (is_null($documentProcessOnMonth)) {
                $peopleArrayData = [
                    "info"          =>  [],
                    "essalud"       =>  [],
                    "familiares"    =>  [],
                    "telefonos"     =>  [],
                    "correos"       =>  [],
                    "sbs"           =>  []///////////////// modifidicacion////////////
                ];

                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.2.][INFO API][START]:".date("Y-m-d H:i:s"));
                $peopleInfoByApi = $serchPeopleInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.2.][INFO API][RESULT]:".json_encode($peopleInfoByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.2.][INFO API][END]:".date("Y-m-d H:i:s"));
                if (isset($peopleInfoByApi["result"])) {
                    $objDetail->status = "NOTDATA";
                    $objDetail->save();
                    $this->job->delete();
                }
                $peopleArrayData["info"] = $peopleInfoByApi;

                $peopleEssaludByApi = $serchPeopleEssaludInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.3.][ESSALUD API][RESULT]:".json_encode($peopleEssaludByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.3.][ESSALUD API][END]:".date("Y-m-d H:i:s"));
                if (!isset($peopleEssaludByApi["result"])) {
                    $peopleArrayData["essalud"] = $peopleEssaludByApi;
                }

                $peopleFamiliarByApi = $serchPeopleFamiliarInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.3.][FAMILIARES API][RESULT]:".json_encode($peopleFamiliarByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.3.][FAMILIARES API][END]:".date("Y-m-d H:i:s"));
                if (!isset($peopleFamiliarByApi["result"])) {
                    $peopleArrayData["familiares"] = $peopleFamiliarByApi;
                }

                $peopleTelefonosByApi = $serchPeopleTelefonoInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.4.][TELEFONOS API][RESULT]:".json_encode($peopleTelefonosByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.4.][TELEFONOS API][END]:".date("Y-m-d H:i:s"));
                if (!isset($peopleTelefonosByApi["result"])) {
                    $peopleArrayData["telefonos"] = $peopleTelefonosByApi;
                }

                $peopleCorreosByApi = $serchPeopleCorreoInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.5.][CORREOS API][RESULT]:".json_encode($peopleCorreosByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.5.][CORREOS API][END]:".date("Y-m-d H:i:s"));
                if (!isset($peopleCorreosByApi["result"])) {
                    $peopleArrayData["correos"] = $peopleCorreosByApi;
                  
                    
                }
                
                ///////////////// modifidicacion////////////sbs_detalle
                
                $peoplesbsByApi = $SerchPeopleSbsInterface->getByApi($objDetail->document);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.4.][SBS API][RESULT]:".json_encode($peoplesbsByApi));
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.4.][SBS API][END]:".date("Y-m-d H:i:s"));
                if (!isset($peoplesbsByApi["result"])) {
                    $peopleArrayData["sbs"] = $peoplesbsByApi;
                    
                    
                }
                
                
//////////////////////////////////////////////////////
                $jobSource = (
                    new UpdateSource(
                        $peopleArrayData,
                        $request["id"],
                        $this->_isLatestRecord
                    )
                )
                ->onQueue('serch:update_source')
                ->delay(now()->addSeconds(3));
                $jobSourceId = dispatch($jobSource);

                $objDetail->status = "PROCESS";
                $objDetail->save();

                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA RETORNA INFORMACIÓN");
            } else {
                $objDetail->status = "REPEAT";
                $objDetail->save();

                $job = (new ValidataRegisterTables(
                    [],
                    $request["id"],
                    $this->_isLatestRecord
                ))->onQueue('validata:register_tables');
                $jobId = dispatch($job);
                
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][5.1.] YA EXISTE ESTE DOCUMENTO EN EL PROCESAMIENTO DE ESTE MES");
            }
            /*dd("aqui");
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
                            Log::channel('serch:process_document')
                                ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.2]MESES REQUEST API:".$meses);
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
                            Log::channel('serch:process_document')
                                ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][3.2]MESES REQUEST API:".$meses);
                        }
                    }
                }
                
                $urlEndpoint.="&meses=".$meses;
                $clientRestFul->setUrlEndpoint($urlEndpoint);
                $clientRestFul->setType("GET");
                $clientRestFul->doAction();
                $responseArray = json_decode($clientRestFul->getResponse(), true);
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.]REQUEST API:".$clientRestFul->getUrlEndpoint());
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.]RESPONSE API:".$clientRestFul->getResponse());

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

                            Log::channel('serch:process_document')
                                ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA RETORNA INFORMACIÓN");
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

                            Log::channel('serch:process_document')
                                ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA RETORNA ERROR");
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

                        Log::channel('serch:process_document')
                            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.1.] EL RESPONSE DE VAlIDATA NO TIENE INFORMACIÓN");
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

                    Log::channel('serch:process_document')
                        ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][5.]CURL ERROR:".$responseArray["curl_error"]);
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
                
                Log::channel('serch:process_document')
                    ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][5.1.] YA EXISTE ESTE DOCUMENTO EN EL PROCESAMIENTO DE ESTE MES");
            }*/
        }
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}][4.]END:".date("Y-m-d H:i:s"));
        Log::channel('serch:process_document')
            ->info("[SERCH:PROCESSDOCUMENT][{$objDetail->document}]---------------------------------------");
    }
}
