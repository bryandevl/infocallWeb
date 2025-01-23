<?php namespace App\Console\Commands\Operador;

use Illuminate\Console\Command;
use App\Operador\Handlers\UploadProcessTranslateListInterface;
use App\Operador\Models\UploadProcessTranslate;
use App\Operador\Models\UploadProcessTranslateDetail;
use App\Helpers\InlineEmail;
use DB;
use Log;

class TranslateTextNotification extends Command
{
    protected $signature = "
        translate_text:notification
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
        UploadProcessTranslateListInterface $uploadProcessTranslateListInterface
    ) {
        Log::channel('operador')->info("[PROCESO DE NOTIFICACIÓN DE EMAIL]");
        Log::channel('operador')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $limit = !is_null($this->option("limit"))? $this->option("limit") : 10;
        $whereTmp = [
            "equals" => ["sending_email_notification" => 0, "is_process" => 1],
            "raw" => []
        ];

        $uploads = $uploadProcessTranslateListInterface->list($whereTmp)
            ->limit($limit)->offset(0)
            ->orderBy("id", "ASC")->get()
            ->toArray();

        foreach ($uploads as $key => $value) {
            Log::channel('operador')->info("---1. FECHA DE CARGA: ".$value['date_upload']);
            Log::channel('operador')->info("---2. ENTIDAD FINANCIERA: ".$value['finance_entity']['description']);
            
            $detail = UploadProcessTranslateDetail::select("*", DB::raw("SUBSTRING_INDEX(file_path, '/', -1) AS fileName"))
                ->where("upload_process_translate_id", $value["id"])
                ->get()->toArray();

            $data = [
                "detail"    =>  $detail,
                "upload"    =>  $value
            ];

            $inlineEmail = new InlineEmail("notifications.translate_voice_to_text", $data);
            $content  = $inlineEmail->convert();
            $email = $value["email_notification"];//$notifiable->email;

            try {
                \Mail::send(
                    "notifications.inline_template", 
                    ["content" => $content], 
                    function ($m) use ($email){
                        $m->to($email, "CR Reportes")
                            ->subject(env("APP_NAME_BUSSINESS", "")." - Notificación de Traducción de Voz a Texto");
                   }
                );
                if (count(\Mail::failures()) <= 0) {
                    UploadProcessTranslate::where("id", $value["id"])->update(["sending_email_notification" => 1]);
                    Log::channel('operador')->info("---3. NOTIFICACIÓN ENVIADA AL EMAIL ".$email);
                } else {
                    Log::channel('operador')->info("---3. NOTIFICACIÓN NO ENVIADA AL EMAIL ".$email);
                }
            } catch (Exception $e) {
                Log::channel('operador')->info("---3. ERRO DE NOTIFICACIÓN AL ENVIAR AL EMAIL ".$email);
            }
        }
        Log::channel('operador')->info("F.FIN: ".date('Y-m-d H:i:s'));
    }
}
