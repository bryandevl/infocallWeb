<?php namespace App\Serch\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Serch\Models\SerchLog;
use App\Serch\Models\SerchLogApi;
use App\Master\Models\SourceLog;
use App\Master\Models\SourceLogTable;
use App\Helpers\FileHelper;
use App\FrAsignacion;
use App\Serch\Exports\SerchLogExport;
use App\Traits\LogTrait;
use DB;
use Chart;

class LogSerchController extends Controller
{
    use LogTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $fecha = explode(" - ", $request->fecha);
        if ($request->ajax()) {
            $serchLogs = $this->listLog($request)->whereRaw("(DATE(created_at) BETWEEN '$fecha[0]' AND '$fecha[1]' )");

            return datatables()->of(
                $serchLogs
            )->toJson();
        }
        $campaignArray = [];
        $cPeriodoArray = [];
        $campaignArray = FrAsignacion::groupBy("campaign_id")
            ->pluck("campaign_id")
            ->toArray();
        $cPeriodoArray = FrAsignacion::groupBy("cPERIODO")
            ->whereRaw("cPERIODO IS NOT NULL")
            ->orderBy("cPERIODO", "DESC")
            ->pluck("cPERIODO")
            ->toArray();
        $personas = SerchLog::get();
        return view(
            "serch.log.index",
            compact(
                "personas",
                "campaignArray",
                "cPeriodoArray"
            )
        );
    }

    public function listDni(Request $request)
    {
        if ($request->ajax()) {
            $tipo = $request->has("tipo")? $request->tipo : "";
            $id = $request->has("log_id")? $request->log_id : null;
            switch ($tipo) {
                case "SERCHLOG":
                    return SerchLog::with("logApi")->find($id);
                    break;
                case "SOURCELOG":
                    return SourceLog::with("logTable")->find($id);
                    break;
                default:
                    break;
            }
        }
    }

    public function xlsLog(Request $request)
    {
        $id = $request->has("id")? $request->id : null;
        $log = $this->show($request);
        if (!is_null($log)) {
            $log = $log->toArray();
            return (new SerchLogExport($log))->download("ReporteSerchLog_".$log["code"].".xls");
        }
    }

    public function formatReportSerch($data = [])
    {
        $report = [];
        foreach ($data as $key => $value) {
            foreach ($value["detail"] as $key2 => $value2) {
                $report[] = [
                    "API" => $value["api"],
                    "DOCUMENTO" => $value2["documento"],
                    "TOTAL" => $value2["total"]
                ];
            }
        }
        return $report;
    }

    public function formatReportSource($data = [])
    {
        $report = [];
        foreach ($data as $key => $value) {
            foreach ($value["detail"] as $key2 => $value2) {
                $report[] = [
                    "TABLE" => $value["source"],
                    "DOCUMENTO" => $value2["documento"],
                    "NUEVOS" => $value2["total_new"],
                    "ACTUALIZADOS" => $value2["total_update"],
                    "ELIMINADOS" => $value2["total_delete"]
                ];
            }
        }
        return $report;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $id = $request->has("id")? $request->id : null;

        $obj = SerchLog::with([
            "detail" => function($q) {
                $q->select([
                    "id",
                    "serch_log_id",
                    "document",
                    "status",
                    "job_id"
                ]);
            }
        ])->find($id);
        return $obj;
    }

    public function showModal($dni)
    {
        //$data = Essalud::find($dni);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    
    public function showChart(Request $request)
    {
        $campaignId = isset($request->campaign_id)? $request->campaign_id : "";
        $cPeriodo = isset($request->cPERIODO)? $request->cPERIODO : "";
        $queryTotales = "
        SELECT 
            COUNT(*) AS 'CANTIDAD',
            ISNULL(cACTIVO, '1') AS 'ESTADOREGISTRO',
            cSendProcess AS 'ESTADOPROCESAMIENTO',
            campaign_id AS 'campaignId'
        FROM FR_ASIGNACION
            WHERE 1=1";
        if ($campaignId !="") {
            $queryTotales.=" AND campaign_id = '{$campaignId}' ";
        }
        $queryTotales.=" AND cPERIODO = '{$cPeriodo}' ";
        //$queryTotales.=" AND cSendProcess IN (0,1) ";
        //$queryTotales.=" AND (cACTIVO IS NULL OR cACTIVO ='0') ";
        $queryTotales.=" GROUP BY cACTIVO, cSendProcess, campaign_id ";
        
        $totales = json_decode(json_encode(DB::connection("sqlsrv")->select($queryTotales)), true);

        $seriesData = [
            ["name" =>  "PENDIENTE", "y" => 0],
            ["name" =>  "ASIGNADO A ENCOLAR", "y" => 0],
            ["name" =>  "PROCESADO BASE", "y" => 0],
            ["name" =>  "OTROS", "y" => 0]
        ];
        $campaignsArray = [];
        $campaignsResultArray = [
            "PENDIENTE" => [],
            "ASIGNADO A ENCOLAR" => [],
            "PROCESADO BASE" => [],
            "OTROS" => []
        ];
        
        foreach ($totales as $key => $value) {
            $campaignIdTmp = $value["campaignId"];
            if (!isset($campaignsResultArray["PENDIENTE"][$campaignIdTmp])) {
                $campaignsResultArray["PENDIENTE"][$campaignIdTmp] = 0;
            }
            if (!isset($campaignsResultArray["ASIGNADO A ENCOLAR"][$campaignIdTmp])) {
                $campaignsResultArray["ASIGNADO A ENCOLAR"][$campaignIdTmp] = 0;
            }
            if (!isset($campaignsResultArray["PROCESADO BASE"][$campaignIdTmp])) {
                $campaignsResultArray["PROCESADO BASE"][$campaignIdTmp] = 0;
            }
            if (!isset($campaignsResultArray["OTROS"][$campaignIdTmp])) {
                $campaignsResultArray["OTROS"][$campaignIdTmp] = 0;
            }
            if ((int)$value["ESTADOREGISTRO"] == 1) {
                if ((int)$value["ESTADOPROCESAMIENTO"] == 1) {
                    $seriesData[1]["y"]+=(int)$value["CANTIDAD"];
                    $campaignsResultArray["ASIGNADO A ENCOLAR"][$campaignIdTmp]+=(int)$value["CANTIDAD"];
                } else {
                    $seriesData[0]["y"]+=(int)$value["CANTIDAD"];
                    $campaignsResultArray["PENDIENTE"][$campaignIdTmp]+=(int)$value["CANTIDAD"];
                }
            } else {
                if ((int)$value["ESTADOPROCESAMIENTO"] == 1) {
                    $seriesData[2]["y"]+=(int)$value["CANTIDAD"];
                    $campaignsResultArray["PROCESADO BASE"][$campaignIdTmp]+=(int)$value["CANTIDAD"];
                } else {
                    $seriesData[3]["y"]+=(int)$value["CANTIDAD"];
                    $campaignsResultArray["OTROS"][$campaignIdTmp]+=(int)$value["CANTIDAD"];
                }
            }
            $campaignsArray[$campaignIdTmp] = $campaignIdTmp;
        }

        $chartTotales = Chart::title([
            "text"      => "Estados del Proceso del Período {$cPeriodo}"
        ])->chart([
            "type"      => "pie",
            "renderTo"  => "contentChartTotales",
        ])->subtitle([
            "text"      =>  ($campaignId == "")? "# Documentos Totales" : "# Documentos de Campaña {$campaignId}",
        ])->legend([
            "layout"    => 'vertikal',
            "align"     => 'center',
            "verticalAlign" => "middle",
        ])->series(
            [
                [
                    "name"  => "Documentos",
                    "colorByPoint" => true,
                    "data"  =>  $seriesData
                ],
            ]
        )->display();

        $chartCampaigns = view(
            "validata.log.partial._partial_log_resumen_by_campaign",
            compact(
                "campaignsArray",
                "campaignsResultArray"
            )
        )->render();

        return [
            "chartTotales" => $chartTotales,
            "chartCampaigns" => $chartCampaigns
        ];
    }
}
