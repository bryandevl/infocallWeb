<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Serch\Handlers\SerchPeopleInfoInterface;
use App\Master\Handlers\SourceLogInterface;
use App\Models\Essalud;
use App\Master\Models\PersonaEssalud;
use App\Master\Models\SourceLogTable;
use App\Master\Models\SourceLogTableDetail;
use Illuminate\Support\Facades\DB;
use Log;

class EssaludSource extends Command
{
    protected $signature = "
        source:essalud";

    protected $description = 'Actualizacion de Tabla essalud de INFOCALL';

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
        SourceLogInterface $sourceLogInterface
    ) {
        Log::channel('source')->info("UPDATE DE INFO DE ESSALUD DE ORIGEN");
        Log::channel('source')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $listSource = DB::table("infocall_source_cron")
            ->whereRaw("updated_at IS NULL")
            ->get(["num_documento"]);
        $listSource = json_decode(json_encode($listSource), true);

        Log::channel('source')->info("[1] : Obteniendo total de Documentos Activos");

        $sourceLog = $sourceLogInterface->getLatestByCache();
        $sourceLogTable = new SourceLogTable;
        $sourceLogTable->source = "ESSALUD";
        $sourceLogTable->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTable->time_start = date("Y-m-d H:i:s");
        $sourceLogTable->save();

        $nuevos = 0;

        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            $infoPeople = $serchPeopleInfoInterface->getByBD($document);

            $nuevosTmp = 0;

            if (!is_null($infoPeople)) {
                $personaId = $infoPeople->id;
                $infoPeopleEssalud = PersonaEssalud::with("empresa")->where("persona_id", $personaId)->get()->toArray();

                foreach ($infoPeopleEssalud as $key2 => $value2) {
                    $whereTmp = [
                        "documento" => $value2["documento"],
                        "periodo" => $value2["periodo"],
                        "ruc" => $value2["empresa"]["ruc"]
                    ];
                    $objEssaludSource = Essalud::where($whereTmp)->first();
                    if (is_null($objEssaludSource)) {
                        DB::beginTransaction();
                        try {
                            $objEssaludSource = new Essalud;
                            $objEssaludSource->documento = $value2["documento"];
                            $empresaTmp = $value2["empresa"]["razonsocial"];
                            $empresaTmp = substr($empresaTmp, 0, 119);
                            $objEssaludSource->empresa = $empresaTmp;
                            $objEssaludSource->ruc = $value2["empresa"]["ruc"];
                            $objEssaludSource->periodo = $value2["periodo"];
                            $objEssaludSource->condicion = $value2["situacion"];
                            $sueldoTmp = $value2["sueldo"];
                            if ($sueldoTmp > 2147483647) {
                                $sueldoTmp = 2147483647;
                            }
                            $objEssaludSource->sueldo = (double)$sueldoTmp;
                            $objEssaludSource->created_at = date("Y-m-d H:i:s");
                            $objEssaludSource->save();
                            DB::commit();
                        } catch (Exception $e) {
                            DB::rollback();
                            Log::channel('source')->info("[2] : Error de BD.".$e->getMessage());
                        }

                        $nuevosTmp++;
                        Log::channel('source')->info("[2] : Nuevo Registro.");
                    } else {
                        Log::channel('source')->info("[3] : Registro ya Existe.");
                    }
                }
            }
            $this->saveLogSourceTableDetail($document, $sourceLogTable->id, $nuevosTmp);
            $nuevos+=$nuevosTmp;
        }

        $sourceLogTable->total_new = $nuevos;
        $sourceLogTable->time_end = date("Y-m-d H:i:s");
        $sourceLogTable->save();
        
        Log::channel('source')->info("[6] : Proceso Finalizado.");
    }

    public function saveLogSourceTableDetail($numDocumento = "", $logSourceId = null, $cantidad = 0)
    {
        if ($numDocumento !="" && !is_null($logSourceId)) {
            $insert = [
                "source_log_table_id" => $logSourceId,
                "documento" => $numDocumento,
                "total" => $cantidad
            ];
            SourceLogTableDetail::insert($insert);
        }
    }
}
