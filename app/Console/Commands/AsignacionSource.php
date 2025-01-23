<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\FrAsignacion;
use App\Serch\Models\SerchLog;
use App\Serch\Models\SerchLogApi;
use App\Master\Models\SourceLog;
use App\Master\Models\SourceLogTable;
use App\Master\Handlers\FrAsignacionListInterface;
use App\Serch\Handlers\SerchLogInterface;
use App\Master\Handlers\SourceLogInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Master\Models\Persona;
use Log;

class AsignacionSource extends Command
{
    protected $signature = "
        source:asignacion
            {--active=}
            {--action=}
            {--latest_update=}
            {--limit=}";

    protected $description = 'Consulta de Fuente de Datos de Documentos';
    protected $_keyCodeCache;
    protected $_keySourceCodeCache;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->_keyCodeCache = \Config::get("serch.keycache.serch_code");
        $this->_keySourceCodeCache = \Config::get("serch.keycache.source_code");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(
        FrAsignacionListInterface $frAsignacionListInterface,
        SerchLogInterface $serchLogInterface,
        SourceLogInterface $sourceLogInterface
    ) {
        $active = !is_null($this->option("active"))? $this->option("active") : 1;
        $action = !is_null($this->option("action"))? $this->option("action") : "";
        $latestUpdate = !is_null($this->option("latest_update"))? $this->option("latest_update") : "";
        $limit = !is_null($this->option("limit"))? $this->option("limit") : 100;

        switch ($action) {
            case "start_source":
                $obj = new SourceLog;
                $obj->code = time();
                $obj->time_start = date("Y-m-d H:i:s");
                $obj->save();

                \Cache::put($this->_keySourceCodeCache, $obj->toArray(), 1*60*60);
                break;
            case "finish_source":
                $sourceLog = $sourceLogInterface->getLatestByCache();
                if (isset($sourceLog["id"])) {
                    $logTable = SourceLogTable::where("source_log_id", $sourceLog["id"])->get();
                    $totalNew = $totalUpdate = $totalDelete = 0;
                    foreach ($logTable as $key2 => $value2) {
                        $totalNew+=$value2->total_new;
                        $totalUpdate+=$value2->total_update;
                        $totalDelete+=$value2->total_delete;
                    }
                    SourceLog::where("id", $sourceLog["id"])->update([
                        "total_new" => $totalNew,
                        "total_update" => $totalUpdate,
                        "total_delete" => $totalDelete,
                        "time_end" => date("Y-m-d H:i:s")
                    ]);
                }
                \Cache::forget($this->_keySourceCodeCache);
                if (Schema::hasTable("infocall_source_cron")) {
                    $query = "CREATE TABLE IF NOT EXISTS ".env('DB_DATABASE_BACKUP', 'forge').".infocall_source_cron_".date("YmdH")." AS SELECT * FROM infocall_source_cron";
                    DB::statement($query);
                    Schema::drop("infocall_source_cron");
                }
                Log::channel('source')->info("[2] : Finalizado Actualización Masiva de Documentos");
                break;
            case 'update':
                $keyCachePersonas = \Config::get("serch.keycache.listPersona");

                Log::channel('source')->info("ACTUALIZAR DOCUMENTOS A PROCESAR");
                $fecUpdate = date("Y-m-d H:i:s");
                $sourceActualizar = DB::table("infocall_source_cron")->pluck("num_documento")->toArray();
                $gruposUpddate = array_chunk($sourceActualizar, 100);

                Log::channel('source')->info("[1] : Iniciando Actualización Masiva de Documentos");
                foreach ($gruposUpddate as $key => $value) {
                    $personas = Persona::select("id")->whereIn("documento", $value)->get()->toArray();
                    foreach ($personas as $key2 => $value2) {
                        $tmp = \Cache::get($keyCachePersonas."_".$value2["id"]);

                        \Cache::forget($keyCachePersonas."_".$value2["id"]);
                    }
                    FrAsignacion::whereIn("cNUM_DOCUMENTO", $value)->update([
                        "dFEC_MODIFICA" => $fecUpdate,
                        "cACTIVO" => 0
                    ]);
                }
                $serchLog = $serchLogInterface->getLatestByCache();
                $totalRequests = 0;
                if (isset($serchLog["id"])) {
                    $logApi = SerchLogApi::where("serch_log_id", $serchLog["id"])->get();
                    foreach ($logApi as $key2 => $value2) {
                        $totalRequests+=$value2->requests_total;
                    }
                    SerchLog::where("id", $serchLog["id"])->update(["requests_total" => $totalRequests, "time_end" => date("Y-m-d H:i:s")]);
                }
                \Cache::forget($this->_keyCodeCache);

                Log::channel('source')->info("[2] : Finalizado Actualización Masiva de Documentos");
                break;
            
            default:
                $obj = new SerchLog;
                $obj->code = time();
                $obj->time_start = date("Y-m-d H:i:s");
                $obj->save();

                Log::channel('source')->info("EXTRACCION DE DOCUMENTOS A PROCESAR");
                $where = [
                    "equals" => [],
                    "raw" => []
                ];
                $where["equals"]["cACTIVO"] = $active;
                if ($latestUpdate !="") {
                    $where["raw"][] = " dFEC_MODIFICA >= CAST('{$latestUpdate}' AS datetime)";
                }
                Log::channel('source')->info("[1] : Obteniendo total de Documentos Activos");
                $listSource = $frAsignacionListInterface->list($where);
                $listSource = $listSource->limit($limit)->offset(0)->get()->toArray();

                $obj->total_source = count($listSource);
                $obj->save();

                \Cache::put($this->_keyCodeCache, $obj->toArray(), 1*60*60);

                Log::channel('source')->info("[2] : Total de Documentos Activos = ".count($listSource));
                Log::channel('source')->info("[3] : Destruyendo BD Temporal");

                if (Schema::hasTable("infocall_source_cron")) {
                    Schema::dropIfExists("infocall_source_cron");
                }
                Log::channel('source')->info("[4] : Creando BD Temporal");
                Schema::create("infocall_source_cron", function (Blueprint $table) {
                    $table->bigIncrements("id");
                    $table->string("num_documento", 12)->nullable();
                    $table->dateTime("created_at")->nullable();
                    $table->dateTime("updated_at")->nullable();
                });
                Log::channel('source')->info("[5] : Registrando en BD Temporal");
                foreach ($listSource as $key => $value) {
                    DB::table("infocall_source_cron")->insert([
                        "num_documento" => $value["cNUM_DOCUMENTO"],
                        "created_at" => date("Y-m-d H:i:s")
                    ]);
                }
                Log::channel('source')->info("[6] : Proceso Finalizado");
                break;
        }
    }
}
