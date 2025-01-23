<?php namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Validata\Handlers\ValidataPeopleInterface;
use App\Validata\Handlers\ValidataPeopleSbsInterface;
use App\Validata\Handlers\ValidataPeopleEssaludInterface;
use App\Validata\Handlers\ValidataPeopleEmailsInterface;
use App\Validata\Handlers\ValidataPeopleRelativesInterface;
use App\Validata\Handlers\ValidataPeoplePhonesInterface;
use App\Validata\Handlers\ValidataPeopleAddressInterface;
use App\Validata\Handlers\ValidataPeopleVehicleInterface;
use App\Validata\Handlers\ValidataCompanyInterface;
use App\Validata\Handlers\ValidataPeopleRepresentativeInterface;
use App\Api\Client\ClientRestFulApi;
use App\Validata\Models\ValidataLog;
use App\Validata\Models\ValidataLogDetail;
use App\Validata\Models\ValidataPeople;
use App\Master\Models\SbsDetalleTmp;
use App\FrAsignacion;
use App\Helpers\CoreHelper;
use App\Helpers\ValidataHelper;
use DB;
use Log;

class ValidataRegisterTables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_data;
    protected $_validataLogDetailId;
    protected $_latestRecord;
    protected $_campaignId;
    protected $_updateFlagCActivo;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $data = [],
        $validataLogDetailId = null,
        $latestRecord = false,
        $campaignId = "",
        $updateFlagCActivo = true
    ) {
        $this->_data = $data;
        $this->_validataLogDetailId = $validataLogDetailId;
        $this->_latestRecord = $latestRecord;
        $this->_campaignId = $campaignId;
        $this->_updateFlagCActivo = $updateFlagCActivo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        ValidataPeopleInterface $validataPeopleInterface,
        ValidataPeopleSbsInterface $validataPeopleSbsInterface,
        ValidataPeopleEssaludInterface $validataPeopleEssaludInterface,
        ValidataPeopleEmailsInterface $validataPeopleEmailsInterface,
        ValidataPeopleRelativesInterface $validataPeopleRelativesInterface,
        ValidataPeoplePhonesInterface $validataPeoplePhonesInterface,
        ValidataPeopleAddressInterface $validataPeopleAddressInterface,
        ValidataPeopleVehicleInterface $validataPeopleVehicleInterface,
        ValidataCompanyInterface $validataCompanyInterface,
        ValidataPeopleRepresentativeInterface $validataPeopleRepresentativeInterface
    ) {
        $jobId = $this->job->getJobId();
        $data = $this->_data;
        $objValidataDetail = ValidataLogDetail::find($this->_validataLogDetailId);
        $document = $objValidataDetail->document;

        Log::channel('validata:register_tables')
            ->info("[VALIDATA:REGISTERTABLES]---------------------------------------");
        Log::channel('validata:register_tables')
            ->info("[VALIDATA:REGISTERTABLES][0.]START:".date("Y-m-d H:i:s"));
        Log::channel('validata:register_tables')
            ->info("[VALIDATA:REGISTERTABLES][1.]JOBID:".$jobId);

        if (isset($data["generales"])) {
            $peopleResponse = $validataPeopleInterface->saveBD($data["generales"]);
            
            Log::channel('validata:register_tables')
                ->info("[VALIDATA:REGISTERTABLES][2.][{$document}]REGISTRADO TABLA validata_people");
            if ((int)$peopleResponse["rst"] == 1) {
                $peopleId = $peopleResponse["obj"]->id;
                if (isset($data["sbs"])) {
                    foreach ($data["sbs"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][3.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][3.][{$document}]REGISTRADO TABLA validata_people_sbs");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][3.][{$document}]REGISTRADO TABLA validata_people_sbs_detail");
                        $validataPeopleSbsInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["essalud"])) {
                    $versionEssalud = \Config::get("validata.api.versionEssalud");
                    Log::channel('validata:register_tables')
                        ->info("[VALIDATA:REGISTERTABLES][4.][{$document}]VERSION API ESSALUD ({$versionEssalud})");
                    foreach ($data["essalud"] as $key => $value) {
                        switch((int)$versionEssalud) {
                            case 1:
                                foreach ($value as $key2 => $value2) {
                                    Log::channel('validata:register_tables')
                                        ->info("[VALIDATA:REGISTERTABLES][4.][{$document}]ITEM {$key} -- {$key2}");
                                    Log::channel('validata:register_tables')
                                        ->info("[VALIDATA:REGISTERTABLES][4.][{$document}]REGISTRADO TABLA validata_people_essalud");
                                    $validataPeopleEssaludInterface->saveBD($value2, $peopleId);
                                }
                                break;
                            default;
                                Log::channel('validata:register_tables')
                                    ->info("[VALIDATA:REGISTERTABLES][4.][{$document}]ITEM {$key}");
                                Log::channel('validata:register_tables')
                                    ->info("[VALIDATA:REGISTERTABLES][4.][{$document}]REGISTRADO TABLA validata_people_essalud");
                                $validataPeopleEssaludInterface->saveBD($value, $peopleId);
                                break;
                        }
                    }
                }
                if (isset($data["correos"])) {
                    foreach ($data["correos"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][5.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][5.][{$document}]REGISTRADO TABLA validata_people_emails");
                        $validataPeopleEmailsInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["familiares"])) {
                    foreach ($data["familiares"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][6.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][6.][{$document}]REGISTRADO TABLA validata_people_relatives");
                        $validataPeopleRelativesInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["telefonos"])) {
                    foreach ($data["telefonos"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][7.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][7.][{$document}]REGISTRADO TABLA validata_people_phones");
                        $validataPeoplePhonesInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["direcciones"])) {
                    foreach ($data["direcciones"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][8.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][8.][{$document}]REGISTRADO TABLA validata_people_address");
                        $validataPeopleAddressInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["vehiculos"])) {
                    foreach ($data["vehiculos"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][9.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][9.][{$document}]REGISTRADO TABLA validata_people_vehicle");
                        $validataPeopleVehicleInterface->saveBD($value, $peopleId);
                    }
                }
                if (isset($data["empresas"])) {
                    foreach ($data["empresas"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][10.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][10.][{$document}]REGISTRADO TABLA validata_company");
                        $resultValidataCompany = $validataCompanyInterface->saveBD($value, $peopleId);
                        if ((int)$resultValidataCompany["rst"] == 1) {
                            $objTmp = $resultValidataCompany["obj"];
                            $companyIdTmp = $objTmp->id;
                            Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][11.][{$document}]ITEM {$key}");
                            Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][11.][{$document}]REGISTRADO TABLA validata_people_company");
                            $validataPeopleInterface->saveCompanyBD($value, $peopleId, $companyIdTmp);
                        }
                    }
                }
                if (isset($data["representantes"])) {
                    foreach ($data["representantes"] as $key => $value) {
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][12.][{$document}]ITEM {$key}");
                        Log::channel('validata:register_tables')
                            ->info("[VALIDATA:REGISTERTABLES][12.][{$document}]REGISTRADO TABLA validata_people_representative");
                        $validataPeopleRepresentativeInterface->saveBD($value, $peopleId);
                    }
                }

                if (!is_null($objValidataDetail)) {
                    $objValidataDetail->status = "PROCESS";
                    $objValidataDetail->save();
                }

                $updateTmp = [];
                //if ($this->_updateFlagCActivo) {
                    $updateTmp["cACTIVO"] = 0;
                    DB::connection("sqlsrv")->statement("SET DATEFORMAT ymd;");
                    $whereTmp = [
                        "cNUM_DOCUMENTO"    =>  $document,
                        "campaign_id"       =>  $objValidataDetail->campaign_id
                    ];
                    FrAsignacion::where($whereTmp)->update($updateTmp);
                //}
                Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}]FR_ASIGNACION CONDICIONALES :".json_encode($whereTmp));
                Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}]FR_ASIGNACION VALORES ACTUALIZADOS :".json_encode($updateTmp));
                Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}]FLAG cACTIVO ACTUALIZADO EN FR_ASIGNACION");

                Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][START] PROCESO SBS DETALLE TMP");

                $cPeriodo = date("Ym");
                $tableSbsTmp = "sbs_detail_tmp_".$cPeriodo;
                
                //$createSbsDetailTmpTableResponse = CoreHelper::createSbsDetailTmpTable($cPeriodo);
                $createSbsDetailTmpTableResponse = false;
                if ($createSbsDetailTmpTableResponse) {
                    $recordSbsDetail = [
                        "cNUM_DOCUMENTO"        =>  $document,
                        "campaign_id"           =>  $objValidataDetail->campaign_id
                    ];
                    $responseSbsDetailTmp = CoreHelper::saveSbsDetailTmp($cPeriodo, $recordSbsDetail);
                    Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}]REGISTRADO EN TABLA {$tableSbsTmp}");

                    $peopleBD = ValidataPeople::with(["sbsLatest", "sbsLatest.detail"])->find($peopleId)->toArray();

                    Log::channel('validata:register_tables')
                        ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][START] REGISTRANDO EN LA TABLA sbs_detalle_tmp");
                    $sbsLatest = $peopleBD["sbs_latest"];
                    if (!is_null($sbsLatest)) {
                        $detailTmp = json_decode(json_encode($sbsLatest["detail"]), true);
                        $rating = ValidataHelper::getRatingBySbsLatest($sbsLatest);
                        $classBtnRating = ValidataHelper::getButtonClassLatest($rating);

                        foreach ($detailTmp as $key3 => $value3) {
                            @$value3["report_date"] = $sbsLatest["report_date"];
                            @$value3["document"] = $document;
                            CoreHelper::saveSbsDetalleTmpRecord($value3, $classBtnRating);
                            Log::channel('validata:register_tables')
                                ->info("[VALIDATA:REGISTERTABLES][--.{$key3}][{$document}] ENTIDAD: ".$value3["entity"]);
                            Log::channel('validata:register_tables')
                                ->info("[VALIDATA:REGISTERTABLES][--.{$key3}][{$document}] TIPO DE CREDITO: ".$value3["credit_type"]);
                            Log::channel('validata:register_tables')
                                ->info("[VALIDATA:REGISTERTABLES][--.{$key3}][{$document}] RECORD REGISTRADO EN TABLA sbs_detalle_tmp");
                        }
                    } else {
                        Log::channel('validata:register_tables')
                        ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][START] SIN INFORMACIÓN DE SBS");
                    }
                    DB::table($tableSbsTmp)
                        ->where([
                            "num_documento" => $document,
                            "campaign_id" => $objValidataDetail->campaign_id
                        ])->update([
                            "status" => "ONPROCESS",
                            "updated_at" => date("Y-m-d H:i:s")
                        ]);

                    Log::channel('validata:register_tables')
                        ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][END] REGISTRANDO EN LA TABLA sbs_detalle_tmp");
                } else {
                    Log::channel('validata:register_tables')
                        ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][END] NO SE PUDO CREAR LA TABLA {$tableSbsTmp}");
                }
                /*Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][START] CRUCE EN LA TABLA sbs_detalle_tmp");

                $sbsDetailRecords = SbsDetalleTmp::where("documento", $document)
                    ->whereRaw("fec_cruce IS NULL")
                    ->get()
                    ->toArray();

                foreach ($sbsDetailRecords as $key3 => $value3) {
                    CoreHelper::mergeSbsDetailTmpRecord($value3);
                }

                Log::channel('validata:register_tables')
                    ->info("[VALIDATA:REGISTERTABLES][--.][{$document}][END] CRUCE EN LA TABLA sbs_detalle_tmp");*/
            }
        } else {
            $updateTmp = [];
            if ($this->_updateFlagCActivo) {
                $updateTmp["cACTIVO"] = 0;
                DB::connection("sqlsrv")->statement("SET DATEFORMAT ymd;");
                FrAsignacion::where([
                    "cNUM_DOCUMENTO"    =>  $document,
                    "campaign_id"       =>  $objValidataDetail->campaign_id
                ])->update($updateTmp);
            }
        }

        if ($this->_latestRecord) {
            $objValidataDetail = ValidataLogDetail::find($this->_validataLogDetailId);
            if (!is_null($objValidataDetail)) {
                $objValidataLog = ValidataLog::find($objValidataDetail->validata_log_id);
                if (!is_null($objValidataLog)) {
                    $objValidataLog->time_end = date("Y-m-d H:i:s");
                    $objValidataLog->save();
                }
            }
        }
        
        Log::channel('validata:register_tables')
            ->info("[VALIDATA:REGISTERTABLES][10.]END:".date("Y-m-d H:i:s"));
        Log::channel('validata:register_tables')
            ->info("[VALIDATA:REGISTERTABLES]---------------------------------------");
    }
}
