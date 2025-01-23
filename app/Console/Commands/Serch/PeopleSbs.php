<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchPeopleSbsInterface;
use App\Serch\Handlers\SerchLogInterface;
use App\Master\Models\Persona;
use App\Serch\Models\SerchLogApi;
use App\Serch\Models\SerchLogApiDetail;
use Illuminate\Support\Facades\DB;
use Log;

class PeopleSbs extends Command
{
    protected $signature = "
        serch:people_sbs
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta de Info SBS por DNI a API de SERCH';

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
        SerchPeopleInfoInterface $serchPeopleInfoInterface,
        SerchPeopleSbsInterface $serchPeopleSbsInterface,
        SerchLogInterface $serchLogInterface
    ) {
        Log::channel('serch')->info("[INFO DE SBS]");
        Log::channel('serch')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $fromSource = !is_null($this->option("from_source"))? $this->option("from_source") : true;
        $document = !is_null($this->option("document"))? $this->option("document") : "";
        $latestUpdate = !is_null($this->option("latest_update"))? $this->option("latest_update") : "";

        $listSource = [];
        $serchLog = $serchLogInterface->getLatestByCache();
        /*
        ** Grabando Log de API INFO
        */
        $objSerchLogApi = new SerchLogApi;
        $objSerchLogApi->serch_log_id = isset($serchLog["id"])? $serchLog["id"] : null;
        $objSerchLogApi->api = "SBS";
        $objSerchLogApi->time_start = date("Y-m-d H:i:s");
        $objSerchLogApi->save();

        $contadorApi = 0;
        $contadorContent = 0;

        if ($document == "" && $fromSource !==true && $fromSource !=="true") {
            Log::channel('serch')->info("[0] : Documento Vacío");
            Log::channel('serch')->info("F.FIN: ".date('Y-m-d H:i:s'));
            return;
        }

        if ($fromSource !==true && $fromSource !=="true") {
            $listSource[] = ["num_documento" => $document];
        } else {
            $listSource = DB::table("infocall_source_cron")
                ->whereRaw("updated_at IS NULL")
                ->get(["num_documento"]);
            $listSource = json_decode(json_encode($listSource), true);
        }

        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            Log::channel('serch')->info("[0] : Documento ".$document);
            Log::channel('serch')->info("[1] : Validando Si existe en BD");

            $peopleInfo = $serchPeopleInfoInterface->getByBD($document);
            $peopleSbsBD = $serchPeopleSbsInterface->getByBD($document);

            if (is_null($peopleSbsBD)) {
                $peopleSbsApi = $serchPeopleSbsInterface->getByApi($document);
                $contadorApi++;
                if (count($peopleSbsApi) > 0 && isset($peopleSbsApi["documento"])) {
                    $contadorContent++;
                    $this->saveLogApiDetail($document, $objSerchLogApi->id, 1);
                    $peopleSbsApi["fec_cron"] = date("Y-m-d H:i:s");
                    if (!is_null($peopleInfo)) {
                        $peopleSbsApi["persona_id"] = $peopleInfo->id;
                        $response = $serchPeopleSbsInterface->saveBD($peopleSbsApi);

                        Log::channel('serch')->info("[2] : Registrado en BD");
                    } else {

                        Log::channel('serch')->info("[3] : Sin DATOS en BD");
                    }
                } else {
                    $this->saveLogApiDetail($document, $objSerchLogApi->id, 0);

                    Log::channel('serch')->info("[3] : Sin DATOS");
                }
            } else {
                if ($latestUpdate !="") {
                    if ($peopleSbsBD->fec_cron < $latestUpdate) {
                        $peopleSbsApi = $serchPeopleSbsInterface->getByApi($document);
                        $contadorApi++;
                        if (count($peopleSbsApi) > 0 && isset($peopleSbsApi["documento"])) {
                            $contadorContent++;
                            $this->saveLogApiDetail($document, $objSerchLogApi->id, 1);
                            $peopleSbsApi["fec_cron"] = date("Y-m-d H:i:s");
                            
                            if (!is_null($peopleInfo)) {
                                $response = $serchPeopleSbsInterface->saveBD($peopleSbsApi, $peopleSbsBD->id);
                                Log::channel('serch')->info("[3] : Actualizado en BD");
                            } else {
                                Log::channel('serch')->info("[3] : Sin DATOS");
                            }
                            
                        } else {
                            $this->saveLogApiDetail($document, $objSerchLogApi->id, 0);

                            Log::channel('serch')->info("[4] : Sin DATOS");
                        }
                    }
                } else {
                    $peopleSbsApi = $serchPeopleSbsInterface->getByApi($document);
                    $contadorApi++;
                    $contadorContent++;
                    $peopleSbsApi["fec_cron"] = date("Y-m-d H:i:s");
                    $response = $serchPeopleSbsInterface->saveBD($peopleSbsApi, $peopleSbsBD->id);

                    Log::channel('serch')->info("[3] : Actualizado en BD");
                }
            }
        }

        $objSerchLogApi->requests_total = $contadorApi;
        $objSerchLogApi->content_total = $contadorContent;
        $objSerchLogApi->time_end = date("Y-m-d H:i:s");
        $objSerchLogApi->save();

        Log::channel('serch')->info("F.FIN: ".date('Y-m-d H:i:s'));
    }

    public function saveLogApiDetail($numDocumento = "", $logApiId = null, $cantidad = 0)
    {
        if ($numDocumento !="" && !is_null($logApiId)) {
            $insert = [
                "serch_log_api_id" => $logApiId,
                "documento" => $numDocumento,
                "total" => $cantidad
            ];
            SerchLogApiDetail::insert($insert);
        }
    }
}
