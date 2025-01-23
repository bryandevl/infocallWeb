<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Master\Handlers\SourceLogInterface;
use App\Master\Models\SourceLog;
use App\Master\Models\SourceLogTable;
use App\Master\Models\SourceLogTableDetail;
use App\Master\Models\PersonaTelefono;
use App\Master\Models\Persona;
use App\Models\Movistar;
use App\Models\MovistarFijo;
use App\Models\Claro;
use App\Models\Entel;
use Illuminate\Support\Facades\DB;
use Log;

class TelefonoSource extends Command
{
    protected $signature = "
        source:telefono";

    protected $description = 'Actualizacion de Fuente de Datos de Telefonos';

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
        Log::channel('source')->info("UPDATE DE INFO DE TELEFONOS DE ORIGEN");
        Log::channel('source')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $listSource = DB::table("infocall_source_cron")
            ->whereRaw("updated_at IS NULL")
            ->get(["num_documento"]);
        $listSource = json_decode(json_encode($listSource), true);

        Log::channel('source')->info("[1] : Obteniendo total de Documentos Activos");

        $sourceLog = $sourceLogInterface->getLatestByCache();
        $timeStart = date("Y-m-d H:i:s");

        $sourceLogTableMovistar = new SourceLogTable;
        $sourceLogTableMovistar->source = "MOVISTAR";
        $sourceLogTableMovistar->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTableMovistar->time_start = $timeStart;
        $sourceLogTableMovistar->save();

        $sourceLogTableClaro = new SourceLogTable;
        $sourceLogTableClaro->source = "CLARO";
        $sourceLogTableClaro->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTableClaro->time_start = $timeStart;
        $sourceLogTableClaro->save();

        $sourceLogTableEntel = new SourceLogTable;
        $sourceLogTableEntel->source = "ENTEL";
        $sourceLogTableEntel->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTableEntel->time_start = $timeStart;
        $sourceLogTableEntel->save(); 

        $sourceLogTableMovistarFijo = new SourceLogTable;
        $sourceLogTableMovistarFijo->source = "MOVISTAR_FIJO";
        $sourceLogTableMovistarFijo->source_log_id = isset($sourceLog["id"])? $sourceLog["id"] : null;
        $sourceLogTableMovistarFijo->time_start = $timeStart;
        $sourceLogTableMovistarFijo->save();

        foreach ($listSource as $key => $value) {
            $document = $value["num_documento"];
            Log::channel('source')->info("[2] : Documento : ".$document);

            $telefonos = PersonaTelefono::where("documento", $document)->get();
            $persona = Persona::where("documento", $document)->first();

            if (!is_null($persona)) {
                $telefonosTmp = $telefonosEliminados = $telefonosNuevos = $telefonosExistentes = [
                    "MOVISTAR" => [
                        "CELULAR" => [],
                        "FIJO" => []
                    ],
                    "CLARO" => [
                        "CELULAR" => [],
                        "FIJO" => []
                    ],
                    "ENTEL" => [
                        "CELULAR" => [],
                        "FIJO" => []
                    ],
                    "BITEL" => [
                        "CELULAR" => [],
                        "FIJO" => []
                    ],
                    "OTRO" => [
                        "CELULAR" => [],
                        "FIJO" => []
                    ],
                ];

                $movistar = Movistar::where("documento", $document)->get();
                $movistarFijo = MovistarFijo::where("documento", $document)->get();

                $claro = Claro::where("documento", $document)->get();
                $entel = Entel::where("documento", $document)->get();

                foreach ($movistar as $key2 => $value2) {
                    $telefonosTmp["MOVISTAR"]["CELULAR"][(int)$value2["numero"]] = (int)$value2["numero"];
                }
                foreach ($movistarFijo as $key2 => $value2) {
                    $telefonosTmp["MOVISTAR"]["FIJO"][(int)$value2["numero"]] = (int)$value2["numero"];
                }
                foreach ($claro as $key2 => $value2) {
                    $telefonosTmp["CLARO"]["CELULAR"][(int)$value2["numero"]] = (int)$value2["numero"];
                }
                foreach ($entel as $key2 => $value2) {
                    $telefonosTmp["ENTEL"]["CELULAR"][(int)$value2["numero"]] = (int)$value2["numero"];
                }
                foreach ($telefonos as $key2 => $value2) {
                    $tipoOperadora = $value2["tipo_operadora"];
                    $tipoTelefono = $value2["tipo_telefono"];

                    if (isset($telefonosTmp[$tipoOperadora][$tipoTelefono])) {
                        $tmpNumeros = $telefonosTmp[$tipoOperadora][$tipoTelefono];
                        $existeIndice = array_search($value2["telefono"], $tmpNumeros);

                        if (isset($tmpNumeros[$existeIndice])) {
                            $telefonosExistentes[$tipoOperadora][$tipoTelefono][] = $value2["telefono"];
                            unset($telefonosTmp[$tipoOperadora][$tipoTelefono][$existeIndice]);
                        } else {
                            $telefonosNuevos[$tipoOperadora][$tipoTelefono][] = $value2["telefono"];
                        }
                    }
                }
                $telefonosEliminados = $telefonosTmp;

                //Registrando nuevos telefonos
                foreach ($telefonosNuevos as $key2 => $value2) {
                    $tipoOperadora = $key2;
                    foreach ($value2 as $key3 => $value3) {
                        $tipoTelefono = $key3;
                        foreach ($value3 as $key4 => $value4) {
                            DB::beginTransaction();
                            try {
                                if ((int)$value4 > 999999999) {
                                    $subStrTmp = substr($value4, 0, 2);
                                    if ($subStrTmp == "51") {
                                        $value4Tmp = explode("51", $value4);
                                        if (isset($value4Tmp[1])) {
                                           $value4 = $value4Tmp[1];
                                        }
                                    }
                                }
                                $insert = [
                                    "documento" => $document,
                                    "numero" => (int)$value4,
                                    "nombre" => $persona["nombres"]." ".$persona["ape_paterno"]." ".$persona["ape_materno"],
                                    "created_at" => date("Y-m-d H:i:s")
                                ];
                                switch ($tipoOperadora) {
                                    case "MOVISTAR":
                                        switch ($tipoTelefono) {
                                            case "CELULAR":
                                                Movistar::insert($insert);
                                                Log::channel('source')->info("[3] : Movistar Nuevo : ".$value4);
                                                break;
                                            case "FIJO":
                                                MovistarFijo::insert($insert);
                                                Log::channel('source')->info("[3] : Movistar Fijo Nuevo : ".$value4);
                                                break;
                                            default:
                                                # code...
                                                break;
                                        }
                                        break;
                                    case "CLARO":
                                        Claro::insert($insert);
                                        Log::channel('source')->info("[3] : Claro Nuevo : ".$value4);
                                        break;
                                    case "ENTEL":
                                        Entel::insert($insert);
                                        Log::channel('source')->info("[3] : Entel Nuevo : ".$value4);
                                        break;
                                    default:
                                        break;
                                }
                                DB::commit();
                            } catch (Exception $e) {
                                Log::channel('source')->info("[3] : Error BD : ".$e->getMessage());
                                DB::rollback();
                            }
                        }
                    }
                }
                //Eliminando Telefonos Anteriores
                foreach ($telefonosEliminados as $key2 => $value2) {
                    $tipoOperadora = $key2;
                    foreach ($value2 as $key3 => $value3) {
                        $tipoTelefono = $key3;
                        foreach ($value3 as $key4 => $value4) {
                            $whereTmp = [
                                "documento" => $document,
                                "numero" => $value4
                            ];
                            switch ($tipoOperadora) {
                                case "MOVISTAR":
                                    switch ($tipoTelefono) {
                                        case "CELULAR":
                                            Movistar::where($whereTmp)->delete();
                                            Log::channel('source')->info("[3] : Movistar Eliminado : ".$value4);
                                            break;
                                        case "FIJO":
                                            MovistarFijo::where($whereTmp)->delete();
                                            Log::channel('source')->info("[3] : Movistar Fijo Eliminado : ".$value4);
                                            break;
                                        default:
                                            # code...
                                            break;
                                    }
                                    break;
                                case "CLARO":
                                    Claro::where($whereTmp)->delete();
                                    Log::channel('source')->info("[3] : Claro Eliminado : ".$value4);
                                    break;
                                case "ENTEL":
                                    Entel::where($whereTmp)->delete();
                                    Log::channel('source')->info("[3] : Entel Eliminado : ".$value4);
                                    break;
                                case "BITEL":
                                    break;
                                default:
                                    # code...
                                    break;
                            }
                        }
                    }
                }

                $sourceLogTableMovistar->total_new+=count($telefonosNuevos["MOVISTAR"]["CELULAR"]);
                $sourceLogTableMovistar->total_delete+=count($telefonosEliminados["MOVISTAR"]["CELULAR"]);
                $sourceLogTableMovistar->total_update+=(abs(count($telefonosEliminados["MOVISTAR"]["CELULAR"]) - count($telefonosNuevos["MOVISTAR"]["CELULAR"])));
                $sourceLogTableMovistar->save();
                $tmpContador = [
                    "new" => count($telefonosNuevos["MOVISTAR"]["CELULAR"]),
                    "update" => (abs(count($telefonosEliminados["MOVISTAR"]["CELULAR"]) - count($telefonosNuevos["MOVISTAR"]["CELULAR"]))),
                    "delete" => count($telefonosEliminados["MOVISTAR"]["CELULAR"])
                ];
                $this->saveLogSourceTableDetail($document, $sourceLogTableMovistar->id, $tmpContador);

                $sourceLogTableClaro->total_new+=count($telefonosNuevos["CLARO"]["CELULAR"]);
                $sourceLogTableClaro->total_delete+=count($telefonosEliminados["CLARO"]["CELULAR"]);
                $sourceLogTableClaro->total_update+=(abs(count($telefonosEliminados["CLARO"]["CELULAR"]) - count($telefonosNuevos["CLARO"]["CELULAR"])));
                $sourceLogTableClaro->save();
                $tmpContador = [
                    "new" => count($telefonosNuevos["CLARO"]["CELULAR"]),
                    "update" => (abs(count($telefonosEliminados["CLARO"]["CELULAR"]) - count($telefonosNuevos["CLARO"]["CELULAR"]))),
                    "delete" => count($telefonosEliminados["CLARO"]["CELULAR"])
                ];
                $this->saveLogSourceTableDetail($document, $sourceLogTableClaro->id, $tmpContador);

                $sourceLogTableEntel->total_new+=count($telefonosNuevos["ENTEL"]["CELULAR"]);
                $sourceLogTableEntel->total_delete+=count($telefonosEliminados["ENTEL"]["CELULAR"]);
                $sourceLogTableEntel->total_update+=(abs(count($telefonosEliminados["ENTEL"]["CELULAR"]) - count($telefonosNuevos["ENTEL"]["CELULAR"])));
                $sourceLogTableEntel->save();
                $tmpContador = [
                    "new" => count($telefonosNuevos["ENTEL"]["CELULAR"]),
                    "update" => (abs(count($telefonosEliminados["ENTEL"]["CELULAR"]) - count($telefonosNuevos["ENTEL"]["CELULAR"]))),
                    "delete" => count($telefonosEliminados["ENTEL"]["CELULAR"])
                ];
                $this->saveLogSourceTableDetail($document, $sourceLogTableEntel->id, $tmpContador);

                $sourceLogTableMovistarFijo->total_new+=count($telefonosNuevos["MOVISTAR"]["FIJO"]);
                $sourceLogTableMovistarFijo->total_delete+=count($telefonosEliminados["MOVISTAR"]["FIJO"]);
                $sourceLogTableMovistarFijo->total_update+=(abs(count($telefonosEliminados["MOVISTAR"]["FIJO"]) - count($telefonosNuevos["MOVISTAR"]["FIJO"])));
                $sourceLogTableMovistarFijo->save();
                $tmpContador = [
                    "new" => count($telefonosNuevos["MOVISTAR"]["FIJO"]),
                    "update" => (abs(count($telefonosEliminados["MOVISTAR"]["FIJO"]) - count($telefonosNuevos["MOVISTAR"]["FIJO"]))),
                    "delete" => count($telefonosEliminados["MOVISTAR"]["FIJO"])
                ];
                $this->saveLogSourceTableDetail($document, $sourceLogTableMovistarFijo->id, $tmpContador);

            }
        }

        $timeEnd = date("Y-m-d H:i:s");
        $sourceLogTableMovistar->time_end = $timeEnd;
        $sourceLogTableMovistar->save();

        $sourceLogTableClaro->time_end = $timeEnd;
        $sourceLogTableClaro->save();

        $sourceLogTableMovistarFijo->time_end = $timeEnd;
        $sourceLogTableMovistarFijo->save();

        $sourceLogTableEntel->time_end = $timeEnd;
        $sourceLogTableEntel->save();

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
