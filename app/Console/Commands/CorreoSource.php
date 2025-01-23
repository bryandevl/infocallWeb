<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Master\Models\PersonaCorreo;
use App\Master\Models\SourceLogTable;
use App\Master\Models\SourceLogTableDetail;
use App\Models\Correo;
use Illuminate\Support\Facades\DB;
use App\Master\Handlers\SourceLogInterface;
use Log;

class CorreoSource extends Command
{
    protected $signature = "
        source:correo";

    protected $description = 'Actualizacion de Fuente de Datos de Correos';

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
    public function handle(SourceLogInterface $sourceLogInterface)
    {
        Log::channel('source')->info("UPDATE DE INFO DE CORREOS DE ORIGEN");
        Log::channel('source')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $listSource = DB::table("infocall_source_cron")
            ->whereRaw("updated_at IS NULL")
            ->get(["num_documento"]);
        $listSource = json_decode(json_encode($listSource), true);

        Log::channel('source')->info("[1] : Obteniendo total de Documentos Activos");

        $sourceLog = $sourceLogInterface->getLatestByCache();
        $sourceLogTable = new SourceLogTable;
        $sourceLogTable->source = "CORREO";
        $sourceLogTable->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTable->time_start = date("Y-m-d H:i:s");
        $sourceLogTable->save();

        $nuevos = 0;
        $eliminados = 0;
        $actualizados = 0;

        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            Log::channel('source')->info("[2] : Documento : ".$document);

            $correos = PersonaCorreo::where("documento", $document)->get();
            $correosSource = Correo::where("documento", $document)->get();

            $correosTmp = [];
            $correosEliminados = [];
            $correosNuevos = [];
            $correosExistentes = [];

            foreach ($correosSource as $key => $value) {
                $correosTmp[] = strtolower(strtolower(str_replace(' ', '', $value["correo"])));
            }
            foreach ($correos as $key => $value) {
                $indiceExiste = array_search($value["email"], $correosTmp);
                if (isset($correosTmp[$indiceExiste])) {
                    $correosExistentes[] = $value["email"];
                    unset($correosTmp[$indiceExiste]);
                } else {
                    $correosNuevos[] = $value["email"];
                }
            }
            $correosEliminados = $correosTmp;

            //Eliminando Correos Anteriores
            foreach ($correosEliminados as $key => $value) {
                Correo::where("documento", $document)->where("correo", $value)->delete();
            }
            $totalTmp = 0;
            //Registrando Nuevos Correos
            foreach ($correosNuevos as $key => $value) {
                DB::beginTransaction();
                try {
                    $obj = new Correo;
                    $obj->documento = $document;
                    $obj->correo = $value;
                    $obj->created_at = date("Y-m-d H:i:s");
                    $obj->save();
                    $totalTmp++;
                    DB::commit();
                } catch (Exception $e) {
                    DB::rollback();
                    Log::channel('source')->info("[3] : Error de BD.".$e->getMessage());
                }
            }

            $nuevos+=count($correosNuevos);
            $eliminados+=count($correosEliminados);
            $actualizados+=count($correosExistentes);

            $totales = [
                "new" => count($correosNuevos),
                "update" => count($correosExistentes),
                "delete" => count($correosEliminados)
            ];
            $this->saveLogSourceTableDetail($document, $sourceLogTable->id, $totales);
        }

        $sourceLogTable->total_new = $nuevos;
        $sourceLogTable->total_update = $actualizados;
        $sourceLogTable->total_delete = $eliminados;
        $sourceLogTable->time_end = date("Y-m-d H:i:s");
        $sourceLogTable->save();

        Log::channel('source')->info("[4] : Proceso Finalizado.");
    }

    public function saveLogSourceTableDetail($numDocumento = "", $logSourceId = null, $totales = ["new" => 0, "update" => 0, "delete" => 0])
    {
        if ($numDocumento !="" && !is_null($logSourceId)) {
            $insert = [
                "source_log_table_id" => $logSourceId,
                "documento" => $numDocumento,
                "total" => $totales["new"],
                "total_new" => $totales["new"],
                "total_update" => $totales["update"],
                "total_delete" => $totales["delete"]
            ];
            SourceLogTableDetail::insert($insert);
        }
    }
}
