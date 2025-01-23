<?php namespace App\Console\Commands\Supervisor;

use Illuminate\Console\Command;
use App\Supervisor\Handlers\UploadCorreoListInterface;
use App\Supervisor\Models\UploadProcessTranslate;
use App\Supervisor\Models\UploadProcessTranslateDetail;
use App\Helpers\InlineEmail;
use App\Models\Correo;
use DB;
use Log;

class UploadCorreoCommand extends Command
{
    protected $signature = "
        upload_correo:csv
            {--action=}
            {--limit=}";

    protected $description = 'Notificación de Email de Carga de Correos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        UploadCorreoListInterface $uploadCorreoListInterface
    ) {
        $uniqId = uniqid();
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 10;
        $action = !is_null($this->option("action"))? $this->option("action") : "";

        Log::channel('supervisor')->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]");
        Log::channel('supervisor')->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]ACCION: {$action}");
        Log::channel('supervisor')->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]F.INICIO: ".date('Y-m-d H:i:s'));

        $whereArray = [
            "equals" => [],
            "raw" => []
        ];

        $uploadCorreos = [];

        switch ($action) {
            case "process":
                $whereArray["equals"] = [
                    "is_process"    =>  0,
                    "sending_email_notification" => 0
                ];
                break;
            case "notify":
                $whereArray["equals"] = [
                    "is_process"    =>  1,
                    "sending_email_notification" => 0
                ];
                break;
            default:
                $whereArray = null;
                break;
        }
        if (!is_null($whereArray)) {
            $uploadCorreos = 
                $uploadCorreoListInterface
                    ->list($whereArray)
                    ->with(["detail"])
                    ->limit($limit)
                    ->offset(0)
                    ->orderBy("id", "ASC")
                    ->get();
        }
        if (count($uploadCorreos) > 0) {
            switch ($action) {
                case "process":
                    foreach ($uploadCorreos as $key => $value) {
                        $total = $process = $failed = 0;
                        $value->date_start_process = date("Y-m-d H:i:s");
                        $value->save();

                        foreach ($value["detail"] as $key2 => $value2) {
                            $fileCsv = config("supervisores.upload_correo.path_csv").$value2->file_path;
                            $result = $this->processFile($fileCsv, $uniqId);
                            $total+=$result["total"];
                            $process+=$result["process"];
                            $failed+=$result["failed"];
                        }

                        $value->total_files = $total;
                        $value->total_files_process = $process;
                        $value->total_files_failed = $failed;
                        $value->is_process = 1;
                        $value->date_finish_process = date("Y-m-d H:i:s");
                        $value->save();
                    }
                    break;
                case "notify":
                    foreach ($uploadCorreos as $key => $value) {
                        $resultSending = $this->sendEmail($value);
                        if ($resultSending) {
                            $value->sending_email_notification=1;
                            $value->save();
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        Log::channel('supervisor')->info("[PROCESO DE CORREO UPLOAD]F.FIN: ".date('Y-m-d H:i:s'));
    }
    public function processFile($fileCsv = "", $uniqId = "") {
        $result = [
            "total"     =>  0,
            "process"   =>  0,
            "failed"    =>  0
        ];
        $fileToRead = fopen($fileCsv, 'r');
 
      /*  while (!feof($fileToRead) ) {
            $lines[] = fgetcsv($fileToRead, 1000, ',');
        }*/
        
        
        while (!feof($fileToRead)) {
    $line = fgetcsv($fileToRead, 1000, ',');
    if ($line !== false) {
        $lines[] = $line;
    }
}
        
        fclose($fileToRead);
        
        if (isset($lines[0])) {
            unset($lines[0]);
        }
        foreach ($lines as $key => $value) {
            $result["total"]++;
            $documento = $value[0];
            
            if (
                isset($value[1]) &&
                isset($value[2]) &&
                !empty($documento) &&
                is_numeric($documento) &&
                in_array((int)$value[2], [0, 1]) &&
                is_numeric($value[2])
            ) {
                $emailRow = strtoupper($value[1]);
                $emailRow = preg_replace(["/\'/", "/\"/"], ["", ""], $emailRow);
                $flagValidado = $value[2];
                DB::beginTransaction();
                try {
                    $listEmailsByDni = Correo::where("documento", $documento)->get();
                    
                    if (count($listEmailsByDni) > 0) {
                        //Existe el DNI
                        $existeEmailOnGroup = false;
                        foreach ($listEmailsByDni as $key2 => $value2) {
                            if (strtoupper($value2->correo) === $emailRow) {
                                $existeEmailOnGroup = true;
                            }
                        }
                        if ($existeEmailOnGroup) {
                            //Existe email
                            Log::channel("supervisor")
                                ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]CORREO ACTUALIZADO: {$emailRow} PARA DOCUMENTO {$documento}");
                            DB::statement("UPDATE correo SET validado = '{$flagValidado}', updated_at = '".date('Y-m-d H:i:s')."' WHERE UPPER(correo) = '{$emailRow}' AND documento ='{$documento}' ");
                            Log::channel("supervisor")
                                ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]CORREO ACTUALIZADO: {$emailRow} PARA DOCUMENTO {$documento}");
                        } else {
                            //No existe email
                            $objCorreo = new Correo;
                            $objCorreo->documento = $documento;
                            $objCorreo->correo = $emailRow;
                            $objCorreo->validado = $flagValidado;
                            $objCorreo->created_at = date("Y-m-d H:i:s");
                            $objCorreo->save();
                            Log::channel("supervisor")
                                ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]NUEVO CORREO: {$emailRow} PARA DOCUMENTO {$documento}");
                        }
                    } else {
                        //No existe el DNI
                        $listEmailsByCorreo = Correo::whereRaw("UPPER(correo) = '{$emailRow}' ")->get();
                        if (count($listEmailsByCorreo) > 0) {
                            //Existe email
                            if (count($listEmailsByCorreo) > 1) {
                                DB::statement("DELETE FROM correo WHERE UPPER(correo) = '{$emailRow}' ");
                                Log::channel("supervisor")
                                    ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]SE HA ELIMINADO REGISTROS DUPLICADOS DE CORREO: {$emailRow}");
                                $objCorreo = new Correo;
                                $objCorreo->documento = $documento;
                                $objCorreo->correo = $emailRow;
                                $objCorreo->validado = $flagValidado;
                                $objCorreo->created_at = date("Y-m-d H:i:s");
                                $objCorreo->save();
                                Log::channel("supervisor")
                                    ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]NUEVO CORREO: {$emailRow} PARA DOCUMENTO {$documento}");
                            } else {
                                DB::statement("UPDATE correo SET documento = '{$documento}', validado = '{$flagValidado}', updated_at = '".date('Y-m-d H:i:s')."' WHERE UPPER(correo) = '{$emailRow}' ");
                                Log::channel("supervisor")
                                    ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]CORREO ACTUALIZADO: {$emailRow} PARA DOCUMENTO {$documento}");
                            }
                        } else {
                            //No existe email
                            $objCorreo = new Correo;
                            $objCorreo->documento = $documento;
                            $objCorreo->correo = $emailRow;
                            $objCorreo->validado = $flagValidado;
                            $objCorreo->created_at = date("Y-m-d H:i:s");
                            $objCorreo->save();
                            Log::channel("supervisor")
                                ->info("[PROCESO DE CORREO UPLOAD][{$uniqId}]NUEVO CORREO: {$emailRow} PARA DOCUMENTO {$documento}");
                        }
                    }

                    DB::commit();
                    $result["process"]++;
                } catch (Exception $e) {
                    DB::rollback();
                    Log::channel("operador")
                        ->info("[PROCESO DE CORREO UPLOAD][EXCEPTION_UPLOAD_CORREO]:".$e->getTraceAsString());
                    $result["failed"]++;
                }
            } else {
                Log::channel("operador")
                    ->info(
                        "[PROCESO DE CORREO UPLOAD][NO_CUMPLE]:".json_encode([
                            "dni" => $value[0],
                            "email" => (isset($value[1])? $value[1] : ""),
                            "validado" => (isset($value[2])? $value[2] : "")
                        ])
                    );
                $result["failed"]++;
            }
        }
        return $result;
    }

    public function sendEmail($upload = []) {
        $data = [
            "detail"    =>  $upload->detail,
            "upload"    =>  $upload
        ];

        $inlineEmail = new InlineEmail("notifications.uploadCorreoNotification", $data);
        $content  = $inlineEmail->convert();
        $email = $upload->email_notification;

        try {
            \Mail::send(
                "notifications.inline_template", 
                ["content" => $content], 
                function ($m) use ($email){
                    $m->to($email, "CR Reportes")
                        ->subject(env("APP_NAME_BUSSINESS", "")." - Notificación de Carga de Correos");
                }
            );
            if (count(\Mail::failures()) <= 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
