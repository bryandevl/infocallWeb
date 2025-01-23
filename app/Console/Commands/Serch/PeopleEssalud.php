<?php namespace App\Console\Commands\Serch;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Serch\Handlers\SerchPeopleEssaludInterface;
use App\Master\Handlers\EmpresaListInterface;
use App\Serch\Handlers\SerchLogInterface;
use App\Master\Models\Persona;
use App\Master\Models\Empresa;
use App\Serch\Models\SerchLogApi;
use App\Serch\Models\SerchLogApiDetail;
use Illuminate\Support\Facades\DB;
use Log;

class PeopleEssalud extends Command
{
    protected $signature = "
        serch:people_essalud
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta de Info Essalud por DNI a API de SERCH';

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
        SerchPeopleEssaludInterface $serchPeopleEssaludInterface,
        EmpresaListInterface $empresaListInterface,
        SerchLogInterface $serchLogInterface
    ) {
        Log::channel('serch')->info("[INFO DE ESSALUD]");
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
        $objSerchLogApi->api = "ESSALUD";
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
            $infoEssalud = $serchPeopleEssaludInterface->getByApi($document);
            $contadorApi++;

            $conDatos = true;
            if (isset($infoEssalud["result"])) {
                if ($infoEssalud["result"] == "SIN DATOS") {
                    $conDatos = false;
                }
            }
            if ($conDatos) {
                if (isset($infoEssalud["documento"])) {
                    unset($infoEssalud["documento"]);
                }

                $contadorResult = count($infoEssalud);
                $contadorContent+=$contadorResult;

                $this->saveLogApiDetail($document, $objSerchLogApi->id, $contadorResult);

                Log::channel('serch')->info("[{$document}][1] : Inicio de Empresas");
                foreach ($infoEssalud as $key2 => $value2) {
                    $ruc = $value2["ruc"];
                    $whereTmpEmpresa = [
                        "equals" => [],
                        "raw" => []
                    ];
                    $whereTmpEmpresa["equals"]["ruc"] = $ruc;
                    $objEmpresa = $empresaListInterface->list($whereTmpEmpresa)->first();
                    if (is_null($objEmpresa)) {
                        $objEmpresa = new Empresa;
                        $objEmpresa->ruc = $ruc;
                        $objEmpresa->razonsocial = $value2["nombre_empresa"];
                        $objEmpresa->save();
                    }
                    $objEmpresa->fec_cron = $fecCron;
                    $objEmpresa->save();

                    Log::channel('serch')->info("[{$document}]-----|*| : Documento ".$document);
                    $value2["fecha"] = str_replace(' ', '', $value2["fecha"]);
                    $whereTmp = [
                        "empresa_id" => $objEmpresa->id,
                        "documento" => $document,
                        "periodo" => $value2["fecha"]
                    ];
                    if (!is_null($infoPeople)) {
                        $whereTmp["persona_id"] = $infoPeople->id;
                    }
                    $objPeopleEssalud = $serchPeopleEssaludInterface->getByBD($whereTmp);
                    if (is_null($objPeopleEssalud)) {
                        $value2["empresa_id"] = $objEmpresa->id;
                        $value2["documento"] = $document;
                        $value2["fec_cron"] = $fecCron;
                        $value2["persona_id"] = !is_null($infoPeople)? $infoPeople->id : null;
                        $serchPeopleEssaludInterface->saveBD($value2);

                        Log::channel('serch')->info("[{$document}][1] : Registro Nuevo");
                    } else {
                        Log::channel('serch')->info("[{$document}][1] : Ya se Registro Record");
                    }
                }
                Log::channel('serch')->info("[{$document}][2] : Fin de Empresas");
            } else {
                $contadorResult = 0;
                $contadorContent+=$contadorResult;

                $this->saveLogApiDetail($document, $objSerchLogApi->id, $contadorResult);

                Log::channel('serch')->info("[{$document}][3] : SIN DATOS");
            }
        }

        $objSerchLogApi->requests_total = $contadorApi;
        $objSerchLogApi->content_total = $contadorContent;
        $objSerchLogApi->time_end = date("Y-m-d H:i:s");
        $objSerchLogApi->save();

        Log::channel('serch')->info(Log::channel('serch')->info("[3] : SIN DATOS"));
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
