<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchLogInterface;
use Illuminate\Support\Facades\DB;
use App\Serch\Models\SerchLogApi;
use App\Serch\Models\SerchLogApiDetail;
use Log;

class PeopleInfo extends Command
{
    protected $signature = "
        serch:people_info
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta de Info por DNI a API de SERCH';
    protected $_keyCodeCache;

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
        SerchLogInterface $serchLogInterface
    ) {
        Log::channel('serch')->info("[INFO DE PERSONAS]");
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
        $objSerchLogApi->api = "INFO";
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
                ->whereRaw("updated_at IS NULL")->get(["num_documento"]);
            $listSource = json_decode(json_encode($listSource), true);
        }
        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            Log::channel('serch')->info("[{$document}]|*| : Documento ".$document);
            Log::channel('serch')->info("[{$document}]-----[1] : Validando Si existe en BD");

            $peopleInfoBD = $serchPeopleInfoInterface->getByBD($document);

            if (is_null($peopleInfoBD)) {
                $peopleInfoApi = $serchPeopleInfoInterface->getByApi($document);
                $contadorApi++;
                Log::channel('serch')->info("[{$document}]-----[Response API] : ".json_encode($peopleInfoApi));
                if (count($peopleInfoApi) > 0 && isset($peopleInfoApi["documento"])) {
                    $contadorContent++;
                    $this->saveLogApiDetail($document, $objSerchLogApi->id, 1);
                    $peopleInfoApi["fec_cron"] = date("Y-m-d H:i:s");
                    $response = $serchPeopleInfoInterface->saveBD($peopleInfoApi);

                    Log::channel('serch')->info("[{$document}]-----[2] : Registro Nuevo en BD");
                } else {
                    $this->saveLogApiDetail($document, $objSerchLogApi->id, 0);

                    Log::channel('serch')->info("[{$document}]-----[3] : No hay DATOS del API");
                }
            } else {
                if ($latestUpdate !="") {
                    if ($peopleInfoBD->fec_cron < $latestUpdate) {
                        $peopleInfoApi = $serchPeopleInfoInterface->getByApi($document);
                        $contadorApi++;
                        Log::channel('serch')->info("[{$document}]-----[Response API] : ".json_encode($peopleInfoApi));
                        if (count($peopleInfoApi) > 0 && isset($peopleInfoApi["documento"])) {
                            $contadorContent++;
                            $this->saveLogApiDetail($document, $objSerchLogApi->id, 1);
                            $peopleInfoApi["fec_cron"] = date("Y-m-d H:i:s");
                            $response = $serchPeopleInfoInterface->saveBD($peopleInfoApi, $peopleInfoBD->id);

                            Log::channel('serch')->info("[{$document}]-----[3] : Registro Actualizado en BD");
                        } else {
                            $contadorApi++;
                            $this->saveLogApiDetail($document, $objSerchLogApi->id, 0);

                            Log::channel('serch')->info("[{$document}]-----[4] : No hay DATOS del API");
                        }
                    }
                } else {
                    $peopleInfoApi = $serchPeopleInfoInterface->getByApi($document);
                    Log::channel('serch')->info("[{$document}]-----[Response API] : ".json_encode($peopleInfoApi));
                    $peopleInfoApi["fec_cron"] = date("Y-m-d H:i:s");
                    $contadorApi++;
                    $contadorContent++;
                    $this->saveLogApiDetail($document, $objSerchLogApi->id, 1);
                    $response = $serchPeopleInfoInterface->saveBD($peopleInfoApi, $peopleInfoBD->id);

                    Log::channel('serch')->info("[{$document}]-----[3] : Actualizado en BD");
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
