<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Master\Models\FinanceEntity;
use App\Master\Models\CreditType;

class SbsDetalleTmpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sbs_detalle_tmp')->truncate();
        $sourceCsv = __DIR__."/REQ_SBS_DETALLE02/sbs_detalle_tmp.csv";
        $insert = [];
        $fila = 1;
        $contador = 0;
        if (($gestor = fopen($sourceCsv, "r")) !== FALSE) {
            while (($datos = fgetcsv($gestor, 1000, ",")) !== FALSE) {
                if ($fila >=2) {
                    echo "--- Inicio Fila {$fila} \n";
                    $time = Carbon::now();
                    $financeEntity = FinanceEntity::where("description", strtoupper($datos[4]))->first();
                    $creditType = CreditType::where("description", strtoupper($datos[5]))->first();
                    $fechaReporte = substr($datos[0], 0, 4)."-".substr($datos[0], 4, 2)."-".substr($datos[0], 6, 2);

                    $tmpInsert = [
                        "fec_reporte"       => $fechaReporte,
                        "documento"         => $datos[1],
                        "ruc"               => $datos[2],
                        "cod_sbs"           => $datos[3],
                        "finance_entity_id" => !is_null($financeEntity)? $financeEntity->id : null,
                        "credit_type_id"    => !is_null($creditType)? $creditType->id : null,
                        "condicion"         => $datos[6],
                        "monto"             => (double)str_replace(",", ".", $datos[7]),
                        "created_at"        => $time,
                        "updated_at"        => $time
                    ];
                    $insert[$contador] = $tmpInsert;
                    print_r($tmpInsert);
                    echo "\n";
                    echo "--- Fin Fila {$fila} \n";
                    $contador++;
                }
                $fila++;
            }
            fclose($gestor);
        }
        DB::table('sbs_detalle_tmp')->insert($insert);
    }
}
