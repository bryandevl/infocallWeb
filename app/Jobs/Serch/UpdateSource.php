<?php namespace App\Jobs\Serch;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Core\Handlers\ReniecConyugeInterface;
use App\Core\Handlers\ReniecHermanoInterface;
use App\Core\Handlers\ReniecFamiliarInterface;
use App\Core\Handlers\ReniecInterface;
use App\Core\Handlers\ClaroInterface;
use App\Core\Handlers\EntelInterface;
use App\Core\Handlers\BitelInterface;
use App\Core\Handlers\MovistarInterface;
use App\Core\Handlers\MovistarFijoInterface;
use App\Core\Handlers\EssaludInterface;
use App\Core\Handlers\CorreoInterface;
use App\Core\Handlers\SbsInterface; ///////////////////////// realice cambios ////////////
use App\Core\Handlers\SbsDetalleInterface; ///////////////////////// realice cambios ////////////
use App\Serch\Models\SerchLog;
use App\Serch\Models\SerchLogDetail;
use App\Models\SbsDetalle;
use App\Helpers\ValidataHelper;
use App\Helpers\CoreHelper;
use App\Helpers\FormatHelper;
use App\FrAsignacion;
use Log;
use DB;

class UpdateSource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_data;
    protected $_serchLogDetailId;
    protected $_latestRecord;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $data = [],
        $serchLogDetailId = null,
        $latestRecord = false
    ) {
        $this->_data = $data;
        $this->_serchLogDetailId = $serchLogDetailId;
        $this->_latestRecord = $latestRecord;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        ReniecFamiliarInterface $reniecFamiliarInterface,
        ReniecHermanoInterface $reniecHermanoInterface,
        ReniecConyugeInterface $reniecConyugeInterface,
        ReniecInterface $reniecInterface,
        ClaroInterface $claroInterface,
        BitelInterface $bitelInterface,
        EntelInterface $entelInterface,
        MovistarInterface $movistarInterface,
        MovistarFijoInterface $movistarFijoInterface,
        EssaludInterface $essaludInterface,
        CorreoInterface $correoInterface,
        SbsInterface $SbsInterface,///////////////////////// realice cambios ////////////
        SbsDetalleInterface $SbsDetalleInterface                               
    ) {
        $jobId = $this->job->getJobId();
        $data = $this->_data;
        $objSerchLogDetail = SerchLogDetail::find($this->_serchLogDetailId);

        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES]---------------------------------------");
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][0.]START:".date("Y-m-d H:i:s"));
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][1.]JOBID:".$jobId);

        if (!is_null($objSerchLogDetail)) {
            $document = $objSerchLogDetail->document;
            $isRuc = CoreHelper::isRuc($document);
            Log::channel('serch:update_source_tables')
                ->info("[SERCH:UPDATESOURCETABLES][{$document}][0.]DOCUMENTO:".$document);

            if (isset($data["info"])) {
                if (!$isRuc) {
                    Log::channel('serch:update_source_tables')
                        ->info("[SERCH:UPDATESOURCETABLES][{$document}][1.]START RENIEC 2018:".date("Y-m-d H:i:s"));
                    $resultSource = 
                        $reniecInterface->saveBySerch($document, $data["info"]);
                    Log::channel('serch:update_source_tables')
                        ->info("[SERCH:UPDATESOURCETABLES][{$document}][1.]RESULT:".json_encode($resultSource));
                    Log::channel('serch:update_source_tables')
                        ->info("[SERCH:UPDATESOURCETABLES][{$document}][1.]END RENIEC 2018:".date("Y-m-d H:i:s"));
                }
            }
            if (isset($data["essalud"])) {
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][2.]START ESSALUD:".date("Y-m-d H:i:s"));
                foreach ($data["essalud"] as $key => $value) {
                    switch ($key) {
                        case "documento":
                            break;
                        default:
                            $resultSource = $essaludInterface->saveBySerch($document, $value);
                            Log::channel('serch:update_source_tables')
                                ->info("[SERCH:UPDATESOURCETABLES][{$document}][2][{$key}]PERIODO:".$value["fecha"]);
                            Log::channel('serch:update_source_tables')
                                ->info("[SERCH:UPDATESOURCETABLES][{$document}][2][{$key}]RUC:".$value["ruc"]);
                            Log::channel('serch:update_source_tables')
                                ->info("[SERCH:UPDATESOURCETABLES][{$document}][2][{$key}]EMPRESA:".strtoupper($value["nombre_empresa"]));
                            Log::channel('serch:update_source_tables')
                                ->info("[SERCH:UPDATESOURCETABLES][{$document}][2][{$key}]SUELDO:".$value["sueldo"]);

                            Log::channel('serch:update_source_tables')
                                ->info("[SERCH:UPDATESOURCETABLES][{$document}][2][{$key}]RESULT:".json_encode($resultSource));
                            break;
                    }
                }
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][2.]END ESSALUD:".date("Y-m-d H:i:s"));
            }
            if (isset($data["familiares"])) {
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.]START FAMILIARES:".date("Y-m-d H:i:s"));
                foreach ($data["familiares"] as $key => $value) {
                    switch ($key) {
                        case "documento":
                            break;
                        default:
                            if (
                                is_numeric($document) && 
                                is_numeric($value["documento_familiar"]) &&
                                CoreHelper::isDni($value["documento_familiar"])
                            ) {
                                switch (strtoupper($value["tipo_relacion"])) {
                                    case 'H': //Hijo
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.1]DOC.HIJO:".$value["documento_familiar"]);
                                        $value["tipo_relacion"] = "HIJO";
                                        $resultSource = $reniecFamiliarInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.1]DOC.HIJO RESULT:".json_encode($resultSource));
                                        break;
                                    case 'HERMANO':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.2]DOC.HERMANO:".$value["documento_familiar"]);
                                        $resultSource = $reniecHermanoInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.2]DOC.HERMANO RESULT:".json_encode($resultSource));
                                        break;
                                    case 'C': //Concubino
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.3]DOC.CONCUBINO:".$value["documento_familiar"]);
                                        $value["tipo_relacion"] = "CONCUBINO";
                                        $resultSource = $reniecConyugeInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.3]DOC.CONCUBINO RESULT:".json_encode($resultSource));
                                        break;
                                    case 'G': //Conyuge
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.4]DOC.CONYUGE:".$value["documento_familiar"]);
                                        $value["tipo_relacion"] = "CONYUGE";
                                        $resultSource = $reniecConyugeInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.4]DOC.CONYUGE RESULT:".json_encode($resultSource));
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                            }
                            break;
                    }
                    
                }
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][3.]END FAMILIARES:".date("Y-m-d H:i:s"));
            }
            
            if (isset($data["telefonos"])) {
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.]START TELEFONOS:".date("Y-m-d H:i:s"));
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.]DATA_TELEFONOS:".json_encode($data["telefonos"]));
                foreach ($data["telefonos"] as $key => $value) {
                    @$value["people"] = isset($data["info"])? ValidataHelper::getFullNameGeneral($data["info"]) : "";
                    //@$value["people"] = "";
                    @$value["telefono"] = FormatHelper::extractPhone($value["telefono"]);
                    Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.]INDEX_TELEFONO{$key}:".json_encode($value));
                    if (
                        isset($value["telefono"]) &&
                        is_numeric($value["telefono"]) &&
                        $key != "documento"
                    ) {
                        $origenData = "";
                        if (strpos(strtoupper($value["origen_data"]), "MOVISTAR") !== false) {
                            $origenData = "MOVISTAR";
                        } else if (strpos(strtoupper($value["origen_data"]), "FIJOS") !== false) {
                            $origenData = "MOVISTAR";
                        } else if (strpos(strtoupper($value["origen_data"]), "CLARO") !== false) {
                            $origenData = "CLARO";
                        } else if (strpos(strtoupper($value["origen_data"]), "ENTEL") !== false) {
                            $origenData = "ENTEL";
                        } else if (strpos(strtoupper($value["origen_data"]), "BITEL") !== false) {
                            $origenData = "BITEL";
                        }
                        Log::channel('serch:update_source_tables')
                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.0]ORIGEN_DATA:".$origenData);

                        switch (strtoupper($value["tipo_telefono"])) {
                            case 'F':
                            case 'FIJO':
                                switch ($origenData) {
                                    case 'CLARO':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.2]FIJO CLARO:".$value["telefono"]);
                                        $resultSource = $claroInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.2]FIJO CLARO RESULT:".json_encode($resultSource));
                                        break;
                                    default:
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.1]MOVISTAR FIJO:".$value["telefono"]);
                                        if (CoreHelper::isFijo($value["telefono"])) {
                                            $resultSource = $movistarFijoInterface->saveBySerch($document, $value);
                                        } else {
                                            Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.1]MOVISTAR FIJO:".$value["telefono"]." NO ES FIJO");
                                        }
                                        
                                        /*Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.1.1]MOVISTAR FIJO RESULT:".json_encode($resultSource));*/
                                        break;
                                }
                                break;
                            case 'CELULAR':
                            case 'C':
                                switch ($origenData) {
                                    case 'CLARO':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.1]CELULAR CLARO:".$value["telefono"]);
                                        $resultSource = $claroInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.1]CELULAR CLARO RESULT:".json_encode($resultSource));
                                        break;
                                    case 'MOVISTAR':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.2]CELULAR MOVISTAR:".$value["telefono"]);
                                        $resultSource = $movistarInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.2]CELULAR MOVISTAR RESULT:".json_encode($resultSource));
                                        break;
                                    case 'ENTEL':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.3]CELULAR ENTEL:".$value["telefono"]);
                                        $resultSource = $entelInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.3]CELULAR ENTEL RESULT:".json_encode($resultSource));
                                        break;
                                    case 'BITEL':
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.4]CELULAR BITEL:".$value["telefono"]);
                                        $resultSource = $bitelInterface->saveBySerch($document, $value);
                                        Log::channel('serch:update_source_tables')
                                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.2.4]CELULAR BITEL RESULT:".json_encode($resultSource));
                                        # code...
                                        break;
                                    default:
                                        # code...
                                        break;
                                }
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
                
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][4.]END TELEFONOS:".date("Y-m-d H:i:s"));
            }
            if (isset($data["correos"])) {
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][5.]START CORREOS:".date("Y-m-d H:i:s"));
                foreach ($data["correos"] as $key => $value) {
                    if ($key !== "documento") {
                        Log::channel('serch:update_source_tables')
                        ->info("[SERCH:UPDATESOURCETABLES][{$document}][5][{$key}]CORREO: ".$value["correo"]);
                        $resultSource = $correoInterface->saveBySerch($document, $value);
                        Log::channel('serch:update_source_tables')
                            ->info("[SERCH:UPDATESOURCETABLES][{$document}][5][{$key}]CORREO RESULT: ".json_encode($resultSource));
                        }
                }
                
                Log::channel('serch:update_source_tables')
                    ->info("[SERCH:UPDATESOURCETABLES][{$document}][5.]END CORREOS:".date("Y-m-d H:i:s"));
            }
            
     ////////////////////////////// CAMBIOOO DE BRYAN///////////////////////////  
    
if (isset($data['sbs'])) {
    Log::channel('serch:update_source_tables')
        ->info("[SERCH:UPDATESOURCETABLES][{$document}][5.]START SBS:".date("Y-m-d H:i:s"));
    
    // Verificar si existe el índice 'sbs' dentro de $data['sbs']
    if (isset($data['sbs']['sbs'])) {
        $resultSbs = $SbsInterface->saveBySerch((array) $data['sbs']['sbs'], $document);
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][{$document}][5.]SBS RESULT:".json_encode($resultSbs));
    } else {
        Log::channel('serch:update_source_tables')
            ->warning("[SERCH:UPDATESOURCETABLES][{$document}][5.]El índice 'sbs' no existe dentro de 'sbs'");
    }

    // Verificar si existe el índice 'sbs_detalle' dentro de $data['sbs']
    if (isset($data['sbs']["sbs_detalle"])) {
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][{$document}][6.]START SBS DETALLE:".date("Y-m-d H:i:s"));
        
        SbsDetalle::where("documento", $document)->delete(); // Puedes activar esta línea si deseas eliminar registros anteriores

        foreach ($data['sbs']["sbs_detalle"] as $sbsDetalle) {
            $resultSbsDetalle = $SbsDetalleInterface->saveBySerch((array) $sbsDetalle, $document);
            Log::channel('serch:update_source_tables')
                ->info("[SERCH:UPDATESOURCETABLES][{$document}][6.]SBS DETALLE RESULT:".json_encode($resultSbsDetalle));
        }
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][{$document}][6.]END SBS DETALLE:".date("Y-m-d H:i:s"));
    } else {
        Log::channel('serch:update_source_tables')
            ->warning("[SERCH:UPDATESOURCETABLES][{$document}][6.]El índice 'sbs_detalle' no existe dentro de 'sbs'");
    }

    Log::channel('serch:update_source_tables')
        ->info("[SERCH:UPDATESOURCETABLES][{$document}][5.]END SBS:".date("Y-m-d H:i:s"));
} else {
    Log::channel('serch:update_source_tables')
        ->warning("[SERCH:UPDATESOURCETABLES][{$document}][5.]El índice 'sbs' no existe en los datos recibidos.");
}

     
     
     
      
  
    

   //////////////////////////////////////////////////////////// 
            
            
            
            
            $updateTmp = [];
            $updateTmp["cACTIVO"] = 0;
            DB::connection("sqlsrv")->statement("SET DATEFORMAT ymd;");
            $whereTmp = [
                "cNUM_DOCUMENTO"    =>  $document,
                "campaign_id"       =>  $objSerchLogDetail->campaign_id
            ];
            FrAsignacion::where($whereTmp)->update($updateTmp);
        }

        if ($this->_latestRecord) {
            $objSerchDetail = SerchLogDetail::find($this->_serchLogDetailId);
            if (!is_null($objSerchDetail)) {
                $objSerchLog = SerchLog::find($objSerchDetail->serch_log_id);
                if (!is_null($objSerchLog)) {
                    $objSerchLog->time_end = date("Y-m-d H:i:s");
                    $objSerchLog->save();
                }
            }
        }
        
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES][9.]END:".date("Y-m-d H:i:s"));
        Log::channel('serch:update_source_tables')
            ->info("[SERCH:UPDATESOURCETABLES]---------------------------------------");
    }
}
