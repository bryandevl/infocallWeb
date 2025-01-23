<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchPeopleFamiliarInterface;
use App\Serch\Handlers\SerchLogInterface;
use App\Master\Models\PersonaTelefono;
use App\Serch\Models\SerchLogApi;
use App\Serch\Models\SerchLogApiDetail;
use Illuminate\Support\Facades\DB;
use Log;

class PeopleFamiliares extends Command
{
    protected $signature = "
        serch:people_familiares
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta de Info de Familiares por DNI a API de SERCH';

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
        SerchPeopleFamiliarInterface $serchPeopleFamiliarInterface,
        SerchLogInterface $serchLogInterface
    ) {
        Log::channel('serch')->info("[INFO DE FAMILIARES]");
        Log::channel('serch')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $fromSource = !is_null($this->option("from_source"))? $this->option("from_source") : true;
        $document = !is_null($this->option("document"))? $this->option("document") : "";
        $latestUpdate = !is_null($this->option("latest_update"))? $this->option("latest_update") : "";
        $fecCron = date("Y-m-d");

        $listSource = [];
        $serchLog = $serchLogInterface->getLatestByCache();
        /*
        ** Grabando Log de API INFO
        */
        $objSerchLogApi = new SerchLogApi;
        $objSerchLogApi->serch_log_id = isset($serchLog["id"])? $serchLog["id"] : null;
        $objSerchLogApi->api = "FAMILIAR";
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
            Log::channel('serch')->info("[{$document}]|*| : Documento ".$document);
            $infoPeople = $serchPeopleInfoInterface->getByBD($document);
            $infoFamiliares = $serchPeopleFamiliarInterface->getByApi($document);
            $contadorApi++;

            $conDatos = true;
            if (isset($infoFamiliares["result"])) {
                if ($infoFamiliares["result"] == "SIN DATOS") {
                    $conDatos = false;
                }
            }
            if ($conDatos) {
                if (isset($infoFamiliares["documento"])) {
                    unset($infoFamiliares["documento"]);
                }
                $contadorResult = 0;

                $this->saveLogApiDetail($document, $objSerchLogApi->id, $contadorResult);

                Log::channel('serch')->info("[{$document}][1] : Inicio de Familiares");
                
                foreach ($infoFamiliares as $key2 => $value2) {
                    Log::channel('serch')->info("[{$document}]-----|*| : Documento ".$document);
                    $whereTmp = [
                        "persona_id" => $infoPeople->id,
                        "documento" => $document,
                        "documento_familiar" => $value2["documento_familiar"]
                    ];
                    $objPeopleFamiliar = $serchPeopleFamiliarInterface->getByBD($whereTmp);

                    if (is_null($objPeopleFamiliar)) {
                        $value2["persona_id"] = $infoPeople->id;
                        $value2["documento"] = $document;

                        $serchPeopleFamiliarInterface->saveBD($value2);
                        Log::channel('serch')->info("[{$document}][2] : Nuevo Familiar");
                    } else {
                        Log::channel('serch')->info("[{$document}][2] : Familiar Registrado");
                    }
                    $contadorResult++;
                }
                $contadorContent+=$contadorResult;
                Log::channel('serch')->info("[3] : Fin de Familiares");
            } else {
                $contadorResult = 0;
                $contadorContent+=$contadorResult;

                $this->saveLogApiDetail($document, $objSerchLogApi->id, $contadorResult);

                Log::channel('serch')->info("[{$document}][4] : SIN DATOS");
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
