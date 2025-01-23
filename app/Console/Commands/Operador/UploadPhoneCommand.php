<?php namespace App\Console\Commands\Operador;

use Illuminate\Console\Command;
use App\Operador\Handlers\UploadPhoneWhatsappListInterface;
use App\Operador\Models\UploadProcessTranslate;
use App\Operador\Models\UploadProcessTranslateDetail;
use App\Helpers\InlineEmail;
use App\Models\Movistar;
use App\Models\Claro;
use App\Models\Entel;
use App\Models\Bitel;
use App\Models\MovistarFijo;
use DB;
use Log;

class UploadPhoneCommand extends Command
{
    protected $signature = "
        upload_phone:csv
            {--action=}
            {--limit=}";

    protected $description = 'Notificación de Email de Traducción de Voz a Texto';

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
        UploadPhoneWhatsappListInterface $uploadPhoneWhatsappListInterface
    ) {
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 10;
        $action = !is_null($this->option("action"))? $this->option("action") : "";

        Log::channel('operador')->info("[PROCESO DE WHATSAPP UPLOAD]");
        Log::channel('operador')->info("[PROCESO DE WHATSAPP UPLOAD]ACCION: {$action}");
        Log::channel('operador')->info("[PROCESO DE WHATSAPP UPLOAD]F.INICIO: ".date('Y-m-d H:i:s'));

        $whereArray = [
            "equals" => [],
            "raw" => []
        ];

        $uploadPhones = [];

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
            $uploadPhones = 
                $uploadPhoneWhatsappListInterface
                    ->list($whereArray)
                    ->with(["detail"])
                    ->limit($limit)
                    ->offset(0)
                    ->orderBy("id", "ASC")
                    ->get();
        }
        if (count($uploadPhones) > 0) {
            switch ($action) {
                case "process":
                    foreach ($uploadPhones as $key => $value) {
                        $total = $process = $failed = 0;
                        $value->date_start_process = date("Y-m-d H:i:s");
                        $value->save();

                        foreach ($value["detail"] as $key2 => $value2) {
                            $fileCsv = \Config::get("operador.upload_phone_whatsapp.path_csv").$value2->file_path;
                            $result = $this->processFile($fileCsv);
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
                    foreach ($uploadPhones as $key => $value) {
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
        Log::channel('operador')->info("[PROCESO DE WHATSAPP UPLOAD]F.INICIO: ".date('Y-m-d H:i:s'));
    }
    public function processFile($fileCsv = "") {
        $result = [
            "total"     =>  0,
            "process"   =>  0,
            "failed"    =>  0
        ];
        $fileToRead = fopen($fileCsv, 'r');
 
        while (!feof($fileToRead) ) {
            $lines[] = fgetcsv($fileToRead, 1000, ',');
        }
        fclose($fileToRead);
        
        if (isset($lines[0])) {
            unset($lines[0]);
        }
        foreach ($lines as $key => $value) {
            $result["total"]++;
            if (
                !empty($value[0]) &&
                is_numeric($value[0]) &&
                in_array((int)$value[1], [0, 1]) &&
                is_numeric($value[1])
            ) {
                DB::beginTransaction();
                try {
                    Bitel::where(["numero" => $value[0]])->update(["with_whatsapp" => $value[1]]);
                    Claro::where(["numero" => $value[0]])->update(["with_whatsapp" => $value[1]]);
                    Movistar::where(["numero" => $value[0]])->update(["with_whatsapp" => $value[1]]);
                    Entel::where(["numero" => $value[0]])->update(["with_whatsapp" => $value[1]]);
                    MovistarFijo::where(["numero" => $value[0]])->update(["with_whatsapp" => $value[1]]);

                    DB::commit();
                    $result["process"]++;
                } catch (Exception $e) {
                    DB::rollback();
                    Log::channel("operador")->info("[PROCESO DE WHATSAPP UPLOAD][EXCEPTION_UPLOAD_PHONE_WHATSAPP]:".$e->getTraceAsString());
                    $result["failed"]++;
                }
            } else {
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

        $inlineEmail = new InlineEmail("notifications.uploadPhoneNotification", $data);
        $content  = $inlineEmail->convert();
        $email = $upload->email_notification;

        try {
            \Mail::send(
                "notifications.inline_template", 
                ["content" => $content], 
                function ($m) use ($email){
                    $m->to($email, "CR Reportes")
                        ->subject(env("APP_NAME_BUSSINESS", "")." - Notificación de Carga de Archivos Whatsapp");
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
