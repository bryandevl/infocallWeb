<?php namespace App\Console\Commands\Test;

use Illuminate\Console\Command;
use App\Master\Models\SbsDetalleTmp;
use App\Master\Models\CreditType;
use App\Master\Models\FinanceEntity;
use Illuminate\Support\Facades\DB;
use App\Helpers\FileHelper;
use Log;

class PeopleSbsDetailTmp extends Command
{
    protected $signature = "
        test:sbs_detail_tmp
            {--document=}
            {--from_source=}
            {--latest_update=}";

    protected $description = 'Consulta y Resultado de Info SBS Detalle por DNI a API de BD';

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
    public function handle() {
        Log::channel('serch')->info("[INFO DE SBS]");
        Log::channel('serch')->info("F.INICIO: ".date('Y-m-d H:i:s'));

        $fromSource = !is_null($this->option("from_source"))? $this->option("from_source") : true;
        $document = !is_null($this->option("document"))? $this->option("document") : "";
        $latestUpdate = !is_null($this->option("latest_update"))? $this->option("latest_update") : "";

        $listSource = SbsDetalleTmp::get()->toArray();
        $creditTypeArray = CreditType::pluck("flag_type", "id");
        $creditTypeArrayGroup = [];

        foreach ($creditTypeArray as $key => $value) {
            if (!isset($creditTypeArrayGroup[$value])) {
                $creditTypeArrayGroup[$value] = [];
            }
            $creditTypeArrayGroup[$value][] = $key;
        }
        $resultado = [];

        $contador = 0;
        foreach ($listSource as $key => $value) {
            $financeEntity = FinanceEntity::find($value["finance_entity_id"]);
            $creditType = CreditType::find($value["credit_type_id"]);
            $updateTmp = [];
            $resultado[$contador] = [
                "FECHA_REPORTE_SBS"     => $value["fec_reporte"],
                "DOCUMENTO"             => $value["documento"],
                "RUC"                   => $value["ruc"],
                "COD_SBS"               => $value["cod_sbs"],
                "ENTIDAD"               => !is_null($financeEntity)? $financeEntity->description : "",
                "TIPO_CREDITO"          => !is_null($creditType)? $creditType->description : "",
                "CONDICION"             => $value["condicion"],
                "MONTO"                 => (double)$value["monto"]       
            ];

            $creditTypeLabelTmp = "";
            $montoSelect = 0;
            foreach ($creditTypeArrayGroup as $key2 => $value2) {
                $montoTmp = in_array($value["credit_type_id"], $value2)? (double)$value["monto"] : 0.00;
                $resultado[$contador][$key2] = $montoTmp;
                if ($montoTmp > 0) {
                    $creditTypeLabelTmp = $key2;
                    $montoSelect = $montoTmp;
                    $updateTmp[strtolower($key2)] = $montoTmp;
                }
            }

            if ($creditTypeLabelTmp !="") {
                switch ((int)$value["finance_entity_id"]) {
                    case 11: // BANCO INTERNACIONAL DEL PERÚ SA (IBK)
                        $updateTmp[strtolower($creditTypeLabelTmp)."_ibk"] = $montoSelect;
                        break;
                    case 3: // BANCO CENCOSUD S.A. (CNC)
                        $updateTmp[strtolower($creditTypeLabelTmp)."_cnc"] = $montoSelect;
                        break;
                    case 7: // BANCO FALABELLA PERU S.A. (CNC)
                        $updateTmp[strtolower($creditTypeLabelTmp)."_fal"] = $montoSelect;
                        break;
                    default:
                        # code...
                        break;
                }
            }

            if ($montoSelect > 0) {
                if (!is_null($financeEntity)) {
                    switch ($financeEntity->type) {
                        case "BANCO":
                            $updateTmp["saldo_banco"] = $montoSelect;
                            break;
                        case "FINANCIERA":
                            $updateTmp["saldo_financiera"] = $montoSelect;
                            break;
                        case "CAJA_EDPYME_OTROS":
                            $updateTmp["saldo_caja_otros"] = $montoSelect;
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            echo "--- Fila {$contador} \n";
            if (count($updateTmp) > 0) {
                $updateTmp["fec_cruce"] = date("Y-m-d H:i:s");
                SbsDetalleTmp::where(["id" => $value["id"]])->update($updateTmp);
            }
            $contador++;
        }
        $filename = public_path("files/sbsDetail".date("YmdHis").".csv");
        FileHelper::exportAndSaveArrayToCsv($resultado, $filename);
        Log::channel('serch')->info("F.FIN: ".date('Y-m-d H:i:s'));
    }
}
