<?php namespace App\Validata\Controllers;

use App\Models\Correo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Validata\Models\ValidataLog;
use App\Validata\Models\ValidataLogApi;
use App\Master\Models\SourceLog;
use App\Master\Models\SourceLogTable;
use App\Helpers\FileHelper;
use Maatwebsite\Excel\Facades\Excel;
use App\Validata\Exports\ValidataLogExport;
use App\FrAsignacion;
use App\Traits\LogTrait;
use DB;
use Chart;

class LogValidataController extends Controller
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
            $columns = isset($request->columns)? $request->columns : [];
            $order = (isset($request->order) && isset($request->order[0]))? $request->order[0] : null;
            $logs = DB::table("validata_log AS vl")
                ->select([
                    "vl.*",
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0)+ vl.duplicate_total_on_period AS 'total'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='REGISTER' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_pending'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='PROCESS' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_process'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='FAILED' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_failed'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='ONQUEUE' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_onqueue'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='REPEAT' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_repeat'"),
                    DB::raw("
                        IFNULL(
                        (SELECT count(vld.id)
                            FROM validata_log_detail AS vld
                            WHERE status='NOTDATA' AND vld.validata_log_id = vl.id
                            AND vld.deleted_at IS NULL),
                        0) AS 'total_notdata'"),
                ])->whereRaw("vl.deleted_at IS NULL");
                if (count($fecha) == 2) {
                    $logs->whereRaw("DATE(vl.created_at) BETWEEN '".$fecha[0]."' AND '".$fecha[1]."'");
                }
                if (is_null($order)) {
                    $logs = $logs->orderBy("vl.created_at", "DESC");
                } else {
                    $columnOrder = $columns[$order["column"]];
                    $columnDir = $order["dir"];
                    $logs = $logs->orderBy($columnOrder["data"], $columnDir);
                }
            return datatables()->of(
                $logs
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
        
        return view(
            "validata.log.index",
            compact(
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
                    return ValidataLog::with("logApi")->find($id);
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
            return (new ValidataLogExport($log))->download("ReporteValidataLog_".$log["code"].".xls");
        }
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

        $obj = ValidataLog::with([
            "detail" => function($q) {
                $q->select([
                    "id",
                    "validata_log_id",
                    "document",
                    "status",
                    "job_id"
                ]);
            },
            "detail.sourceTrace" => function($q) {
                $q->select([
                    "id",
                    "validata_log_detail_id",
                    "document",
                    "action_type",
                    "process_source",
                    "value_create",
                    "value_update"
                ]);
            }
        ])->find($id);
        return $obj;
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
}
