<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReniecHermanos;
use App\Models\Reniec;
use App\Models\ReniecConyuges;
use App\Master\Models\PersonaFamiliar;
use App\Master\Models\Persona;
use App\Master\Models\SourceLogTable;
use App\Master\Models\SourceLogTableDetail;
use Illuminate\Support\Facades\DB;
use App\Master\Handlers\SourceLogInterface;
use Log;

class ReniecSource extends Command
{
    protected $signature = "
        source:reniec
        {--tipo=}";

    protected $description = 'Actualizacion de Fuente de Datos de Documentos';

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
        SourceLogInterface $sourceLogInterface
    ) {
        Log::channel('source')->info("UPDATE DE INFO DE RENIEC DE ORIGEN");
        Log::channel('source')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $tipo = !is_null($this->option("tipo"))? $this->option("tipo") : "";

        $listSource = DB::table("infocall_source_cron")
            ->whereRaw("updated_at IS NULL")
            ->get(["num_documento"]);
        $listSource = json_decode(json_encode($listSource), true);

        Log::channel('source')->info("[1] : Obteniendo total de Documentos Activos");

        $sourceLog = $sourceLogInterface->getLatestByCache();

        switch ($tipo) {
            case "CONYUGE":
            case "CONCUBINO":
                $sourceLogTable = new SourceLogTable;
                $sourceLogTable->source = "RENIEC_CONYUGES";
                $sourceLogTable->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
                $sourceLogTable->time_start = date("Y-m-d H:i:s");
                $sourceLogTable->save();
                break;

            case "PERSONAL":
                $sourceLogTable = new SourceLogTable;
                $sourceLogTable->source = "RENIEC_2018";
                $sourceLogTable->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
                $sourceLogTable->time_start = date("Y-m-d H:i:s");
                $sourceLogTable->save();
                break;

            case "HERMANO":
                $sourceLogTable = new SourceLogTable;
                $sourceLogTable->source = "RENIEC_FAMILIARES";
                $sourceLogTable->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
                $sourceLogTable->time_start = date("Y-m-d H:i:s");
                $sourceLogTable->save();
                break;
            default:
                # code...
                break;
        }

        $nuevos = 0;
        $eliminados = 0;
        $actualizados = 0;

        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            Log::channel('source')->info("[2] : Documento : ".$document);

            $totalTmp = 0;

            if ($tipo !="") {
                $familiares = [];
                switch ($tipo) {
                    case "CONYUGE":
                    case "CONCUBINO":
                    case "HERMANO":
                        $familiares = PersonaFamiliar::where([
                            "documento" => $document,
                            "tipo" => $tipo
                        ])->get();
                        break;
                    case "PERSONAL":
                        $obj = Persona::where("documento", $document)->first();
                        if (!is_null($obj)) {
                            $familiares[] = $obj->toArray();
                        }
                        break;
                    default:
                        # code...
                        break;
                }
                $nuevosTmp = $actualizadosTmp = $eliminadosTmp = 0;
                foreach ($familiares as $key2 => $value2) {
                    DB::beginTransaction();
                    try {
                        switch ($tipo) {
                            case "CONYUGE":
                            case "CONCUBINO":
                                $objFamiliar = ReniecConyuges::where([
                                    "doc_parent" => $document,
                                    "documento" => $value2["documento_familiar"],
                                    "parentezco" => $tipo
                                ])->first();

                                if (is_null($objFamiliar) && is_numeric($value2["documento_familiar"])) {
                                    $objFamiliar = new ReniecConyuges;
                                    $objFamiliar->setPrimaryKey("id");
                                    $objFamiliar->doc_parent = $document;
                                    $objFamiliar->documento = $value2["documento_familiar"];
                                    $objFamiliar->parentezco = $tipo;
                                    //$objFamiliar->created_at = date("Y-m-d H:i:s");
                                    $objFamiliar->nombre = $value2["nombres"]." ".$value2["ape_paterno"]." ".$value2["ape_materno"];
                                    $objFamiliar->save();
                                    $actualizadosTmp++;
                                    $actualizados++;

                                    Log::channel('source')->info("[3] : ".$tipo." Registrado.");
                                }
                                break;
                            case "HERMANO":
                                $objFamiliar = ReniecHermanos::where([
                                    "doc_parent" => $document,
                                    "documento" => $value2["documento_familiar"]
                                ])->first();

                                if (is_null($objFamiliar) && is_numeric($value2["documento_familiar"])) {
                                    $objFamiliar = new ReniecHermanos;
                                    $objFamiliar->setPrimaryKey("id");
                                    $objFamiliar->doc_parent = $document;
                                    $objFamiliar->documento = $value2["documento_familiar"];
                                    $objFamiliar->created_at = date("Y-m-d H:i:s");
                                    $objFamiliar->nombre = $value2["nombres"]." ".$value2["ape_paterno"]." ".$value2["ape_materno"];
                                    $objFamiliar->save();
                                    $actualizadosTmp++;
                                    $actualizados++;

                                    Log::channel('source')->info("[3] : Hermano Registrado.");
                                }
                                break;
                            case "PERSONAL":
                                $objFamiliar = Reniec::where("documento", $value2["documento"])->first();
                                if (is_null($objFamiliar)) {
                                    $objFamiliar = new Reniec;
                                    $objFamiliar->documento = $value2["documento"];
                                    $objFamiliar->apellido_pat = $value2["ape_paterno"];
                                    $objFamiliar->apellido_mat = $value2["ape_materno"];
                                    $objFamiliar->nombre = $value2["nombres"];

                                    $date = new \DateTime($value2["fec_nacimiento"]);
                                    $objFamiliar->fec_nac = $date->format("d/m/Y");

                                    $objFamiliar->ubigeo = $value2["ubigeo_nacimiento"];
                                    $objFamiliar->ubigeo_dir = $value2["ubigeo_direccion"];
                                    $objFamiliar->direccion = $value2["direccion"];
                                    $objFamiliar->sexo = $value2["sexo"];
                                    $objFamiliar->nombre_mad = $value2["madre_nombres"];
                                    $objFamiliar->nombre_pat = $value2["padre_nombres"];
                                    $objFamiliar->edo_civil = $value2["estado_civil"];
                                    $objFamiliar->created_at = date("Y-m-d H:i:s");
                                    $nuevosTmp++;
                                    $nuevos++;

                                    Log::channel('source')->info("[3] : Registro RENIEC2018 Creado.");
                                } else {
                                    $objFamiliar->edo_civil = $value2["estado_civil"];
                                    $objFamiliar->updated_at = date("Y-m-d H:i:s");
                                    $actualizadosTmp++;
                                    $actualizados++;

                                    Log::channel('source')->info("[3] : Registro RENIEC2018 Actualizado.");
                                }
                                $objFamiliar->save();
                                break;
                            default:
                                Log::channel('source')->info("[3] : No esta Implementado.");
                                break;
                        }
                    } catch (Exception $e) {
                        
                    }
                    
                    $totales = [
                        "new" => $nuevosTmp,
                        "update" => $actualizadosTmp,
                        "delete" => $eliminadosTmp
                    ];
                    $this->saveLogSourceTableDetail($document, $sourceLogTable->id, $totales);
                }
            }
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
