<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchPeopleTelefonoInterface;
use App\Serch\Handlers\SerchLogInterface;
use App\Master\Models\PersonaTelefono;
use App\Serch\Models\SerchLogApi;
use App\Serch\Models\SerchLogApiDetail;
use Illuminate\Support\Facades\DB;
use Log;

class PeopleTelefonos extends Command
{
    protected $signature = "
        serch:people_telefonos
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta de Info Telefonos por DNI a API de SERCH';

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
        SerchPeopleTelefonoInterface $serchPeopleTelefonoInterface,
        SerchLogInterface $serchLogInterface
    ) {
        Log::channel('serch')->info("[INFO DE TELEFONOS]");
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
        $objSerchLogApi->api = "TELEFONO";
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
            $infoTelefonos = $serchPeopleTelefonoInterface->getByApi($document);
            $contadorApi++;

            $conDatos = true;
            if (isset($infoTelefonos["result"])) {
                if ($infoTelefonos["result"] == "SIN DATOS") {
                    $conDatos = false;
                }
            }
            if ($conDatos) {
                if (isset($infoTelefonos["documento"])) {
                    unset($infoTelefonos["documento"]);
                }
                Log::channel('serch')->info("[{$document}][1] : Inicio de Telefonos");
                if (!is_null($infoPeople)) {
                    DB::table("persona_telefono")->where("persona_id", $infoPeople->id)->delete();
                }
                $contadorResult = count($infoTelefonos);
                $contadorContent+=$contadorResult;

                $this->saveLogApiDetail($document, $objSerchLogApi->id, $contadorResult);

                foreach ($infoTelefonos as $key2 => $value2) {
                    Log::channel('serch')->info("[{$document}]-----|*| : Documento ".$document);
                    $value2["persona_id"] = is_null($infoPeople)? null : $infoPeople->id;
                    $value2["telefono"] = str_replace(' ', '', $value2["telefono"]);
                    $value2["documento"] = $document;
                    $value2["tipo_telefono"] = str_replace(' ', '', $value2["tipo_telefono"]);
                    $value2["tipo_telefono"] = strtoupper($value2["tipo_telefono"]);

                    $responseCreate = $serchPeopleTelefonoInterface->saveBD($value2);
                    if ((int)$responseCreate["rst"] == 2) {
                        Log::channel('serch')->info("[{$document}]".$responseCreate["msj"]);
                    } else {
                        Log::channel('serch')->info("[{$document}][2] : Telefono Registrado");
                    }
                }
                Log::channel('serch')->info("[{$document}][3] : Fin de Telefonos");
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
