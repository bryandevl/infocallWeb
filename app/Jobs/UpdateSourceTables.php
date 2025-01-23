<?php namespace App\Jobs;

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
use App\Core\Handlers\VehiculosDocumentoInterface;
use App\Core\Handlers\EmpresasDocumentoInterface;
use App\Core\Handlers\EmpresasRepresentanteInterface;
use App\Core\Handlers\EmpresaInterface;
use App\Core\Handlers\EmpresaTelefonoInterface;
use App\Validata\Models\ValidataLogDetail;
use App\Helpers\ValidataHelper;
use App\Helpers\CoreHelper;
use Log;

class UpdateSourceTables implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $_data;
    protected $_validataLogDetailId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $data = [],
        $validataLogDetailId = null
    ) {
        $this->_data = $data;
        $this->_validataLogDetailId = $validataLogDetailId;
    }

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
        VehiculosDocumentoInterface $vehiculosDocumentoInterface,
        EmpresasDocumentoInterface $empresasDocumentoInterface,
        EmpresasRepresentanteInterface $empresasRepresentanteInterface,
        EmpresaInterface $empresaInterface,
        EmpresaTelefonoInterface $empresaTelefonoInterface
    ) {
        $jobId = $this->job->getJobId();
        $data = $this->_data;
        $objValidaLogDetail = ValidataLogDetail::find($this->_validataLogDetailId);

        Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES]---------------------------------------");
        Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES][0.]START:".date("Y-m-d H:i:s"));
        Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES][1.]JOBID:".$jobId);

        if (!is_null($objValidaLogDetail)) {
            $isRuc = CoreHelper::isRuc($objValidaLogDetail->document);
            Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES][0.]DOCUMENTO:".$objValidaLogDetail->document);
            if (isset($data["generales"])) {
                if (!$isRuc) {
                    Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][1.]START RENIEC 2018:".date("Y-m-d H:i:s"));
                    $data["generales"]["direccion"] = ValidataHelper::getLatestAddressByDocument((isset($data["direcciones"])? $data["direcciones"] : []));
                    $resultSource = $reniecInterface->saveBD($data["generales"]);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                    
                    Log::channel('validata:update_source_tables')
                        ->info("[VALIDATA:UPDATESOURCETABLES][1.]END RENIEC 2018:".date("Y-m-d H:i:s"));
                } else {
                    Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][1.]START EMPRESA:".date("Y-m-d H:i:s"));
                    $resultSource = $empresaInterface->saveBD($data["generales"]);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                }
            }
            if (isset($data["essalud"])) {
                $versionEssalud = \Config::get("validata.api.versionEssalud");
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][2.]VERSION API ESSALUD ({$versionEssalud})");

                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][2.]START ESSALUD:".date("Y-m-d H:i:s"));
                foreach ($data["essalud"] as $key => $value) {
                    
                    
                    switch((int)$versionEssalud) {
                        case 1:
                            foreach ($value as $key2 => $value2) {
                                $value2["documento"] = $objValidaLogDetail->document;
                                $resultSource = $essaludInterface->saveBD($value2);
                                ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
            
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}][{$key2}]PERIODO:".$value2["fecha"]);
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}][{$key2}]RUC:".$value2["ruc"]);
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}][{$key2}]EMPRESA:".strtoupper($value2["nombre_empresa"]));
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}][{$key2}]SUELDO:".$value2["sueldo"]);
                            }
                            break;
                        default:
                            $value["documento"] = $objValidaLogDetail->document;
                            $resultSource = $essaludInterface->saveBD($value);
                            ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
        
                            Log::channel('validata:update_source_tables')
                                ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}]PERIODO:".$value["fecha"]);
                            Log::channel('validata:update_source_tables')
                                ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}]RUC:".$value["ruc"]);
                            Log::channel('validata:update_source_tables')
                                ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}]EMPRESA:".strtoupper($value["nombre_empresa"]));
                            Log::channel('validata:update_source_tables')
                                ->info("[VALIDATA:UPDATESOURCETABLES][2][{$key}]SUELDO:".$value["sueldo"]);
                            break;
                    }
                    
                }
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][2.]END ESSALUD:".date("Y-m-d H:i:s"));
            }
            if (isset($data["familiares"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][3.]START FAMILIARES:".date("Y-m-d H:i:s"));
                foreach ($data["familiares"] as $key => $value) {
                    $value["documento"] = $objValidaLogDetail->document;
                    if (is_numeric($objValidaLogDetail->document) && is_numeric($value["documento_familiar"])) {
                        switch (strtoupper($value["tipo_relacion"])) {
                            case 'H': //Hijo
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][3.1]DOC.HIJO:".$value["documento_familiar"]);
                                $value["tipo_relacion"] = "HIJO";

                                $resultSource = $reniecFamiliarInterface->saveBD($value);
                                ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                break;
                            case 'HERMANO':
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][3.2]DOC.HERMANO:".$value["documento_familiar"]);

                                $resultSource = $reniecHermanoInterface->saveBD($value);
                                ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                break;
                            case 'C': //Concubino
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][3.3]DOC.CONCUBINO:".$value["documento_familiar"]);
                                $value["tipo_relacion"] = "CONCUBINO";

                                $resultSource = $reniecConyugeInterface->saveBD($value);
                                ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                break;
                            case 'G': //Conyuge
                                Log::channel('validata:update_source_tables')
                                    ->info("[VALIDATA:UPDATESOURCETABLES][3.4]DOC.CONYUGE:".$value["documento_familiar"]);
                                $value["tipo_relacion"] = "CONYUGE";

                                $resultSource = $reniecConyugeInterface->saveBD($value);
                                ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                break;
                            default:
                                # code...
                                break;
                        }
                    }
                }
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][3.]END FAMILIARES:".date("Y-m-d H:i:s"));
            }
            if (isset($data["telefonos"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][4.]START TELEFONOS:".date("Y-m-d H:i:s"));
                foreach ($data["telefonos"] as $key => $value) {
                    $value["people"] = isset($data["generales"])? ValidataHelper::getFullNameGeneral($data["generales"]) : "";
                    $value["documento"] = $objValidaLogDetail->document;
                    
                    if (is_int($value["telefono"]) || is_numeric($value["telefono"])) {
                        switch (strtoupper($value["tipo_telefono"])) {
                            case 'F':
                                switch (strtoupper($value["origen_data"])) {
                                    case 'CLARO':
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.1.2]FIJO CLARO:".$value["telefono"]);

                                        $resultSource = $claroInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                        break;
                                    default:
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.1.1]MOVISTAR FIJO:".$value["telefono"]);

                                        $resultSource = $movistarFijoInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                        break;
                                }
                                break;
                            case 'C':
                                switch (strtoupper($value["origen_data"])) {
                                    case 'CLARO':
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.2.1]CELULAR CLARO:".$value["telefono"]);

                                        $resultSource = $claroInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                        break;
                                    case 'MOVISTAR':
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.2.2]CELULAR MOVISTAR:".$value["telefono"]);
                                        $resultSource = $movistarInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                        break;
                                    case 'ENTEL':
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.2.3]CELULAR ENTEL:".$value["telefono"]);
                                        $resultSource = $entelInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                                        # code...
                                        break;
                                    case 'BITEL':
                                        Log::channel('validata:update_source_tables')
                                            ->info("[VALIDATA:UPDATESOURCETABLES][4.2.4]CELULAR BITEL:".$value["telefono"]);
                                        $resultSource = $bitelInterface->saveBD($value);
                                        ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
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
                        if ($isRuc) {
                            Log::channel('validata:update_source_tables')
                                ->info("[VALIDATA:UPDATESOURCETABLES][4.2.5]CELULAR RUC:".$value["telefono"]);
                            $resultSource = $empresaTelefonoInterface->saveBD($value);
                            ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                        }
                    }
                }
                
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][4.]END TELEFONOS:".date("Y-m-d H:i:s"));
            }
            if (isset($data["correos"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][5.]START CORREOS:".date("Y-m-d H:i:s"));
                foreach ($data["correos"] as $key => $value) {
                    Log::channel('validata:update_source_tables')
                        ->info("[VALIDATA:UPDATESOURCETABLES][5][{$key}]CORREO:".$value["correo"]);

                    $value["documento"] = $objValidaLogDetail->document;
                    $resultSource = $correoInterface->saveBD($value);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                }
                
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][5.]END CORREOS:".date("Y-m-d H:i:s"));
            }
            if (isset($data["vehiculos"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][6.]START VEHICULOS:".date("Y-m-d H:i:s"));
                foreach ($data["vehiculos"] as $key => $value) {
                    Log::channel('validata:update_source_tables')
                        ->info("[VALIDATA:UPDATESOURCETABLES][6][{$key}]VEHICULO:".$value["placa"]);

                    $value["documento"] = $objValidaLogDetail->document;
                    $resultSource = $vehiculosDocumentoInterface->saveBD($value);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                }
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][6.]END VEHICULOS:".date("Y-m-d H:i:s"));
            }
            if (isset($data["empresas"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][7.]START EMPRESAS:".date("Y-m-d H:i:s"));
                foreach ($data["empresas"] as $key => $value) {
                    Log::channel('validata:update_source_tables')
                        ->info("[VALIDATA:UPDATESOURCETABLES][7][{$key}]EMPRESA:".$value["ruc"]);

                    $value["documento"] = $objValidaLogDetail->document;
                    $resultSource = $empresasDocumentoInterface->saveBD($value);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                }
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][7.]END EMPRESAS:".date("Y-m-d H:i:s"));
            }
            if (isset($data["representantes"])) {
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][8.]START REPRESENTANTES:".date("Y-m-d H:i:s"));
                foreach ($data["representantes"] as $key => $value) {
                    Log::channel('validata:update_source_tables')
                        ->info("[VALIDATA:UPDATESOURCETABLES][8][{$key}]REPRESENTANTE:".$value["documento"]);
                    $value["ruc"] = $objValidaLogDetail->document;
                    $resultSource = $empresasRepresentanteInterface->saveBD($value);
                    ValidataHelper::saveTraceLogDetailSource($objValidaLogDetail->id, $resultSource);
                }
                Log::channel('validata:update_source_tables')
                    ->info("[VALIDATA:UPDATESOURCETABLES][8.]END REPRESENTANTES:".date("Y-m-d H:i:s"));
            }
        }
        
        Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES][9.]END:".date("Y-m-d H:i:s"));
        Log::channel('validata:update_source_tables')
            ->info("[VALIDATA:UPDATESOURCETABLES]---------------------------------------");
    }
}
