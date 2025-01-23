@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-key-o"></i> Validata
@endsection
@section('contentheader_description')
    Reporte SBS de DNI {{$document}}
@endsection
@section('htmlheader_title')
    Reporte SBS de DNI {{$document}}
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Validata - Reporte SBS por DNI</li>
    </ol>
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-validata, #men-validata-reporte-sbs').addClass('active');
    </script>
@endsection
@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('css/reporte-sbs.css')}}">
@endsection

@php
    $latest = date("Y-m-d");
    $latestAmount = 0;
    $classBtnLatest = "btn-unrate";
    $classLabelLatest = "label-lost";
    $monthsLatestTwoYears = [];
    $sbsTwoYears = [];
    $sbsLatestMonth = [];
    $sbsLatestMonthRating = [];
    $rating = [];
    $latestMonth = [];

    $now = date("Y-m", strtotime("-1 month"));
    $start = date("Y-m", strtotime("-2 year"));

    setlocale(LC_TIME, 'es_ES.UTF-8');
    for($i = 11; $i >= 0; $i--) {
        $index = date("Y-m", strtotime("-".(1+$i)." month"));
        $monthsLatestTwoYears[$index] = strtoupper(strftime("%B %Y", strtotime("-".(1+$i)." month")));
    }

    if (isset($people['sbs_latest'])) {
        $rating = [
            "normal_rating"     =>  (int)$people['sbs_latest']['normal_rating'],
            "cpp_rating"        =>  (int)$people['sbs_latest']['cpp_rating'],
            "deficient_rating"  =>  (int)$people['sbs_latest']['deficient_rating'],
            "uncertain_rating"  =>  (int)$people['sbs_latest']['uncertain_rating'],
            "lost_rating"       =>  (int)$people['sbs_latest']['lost_rating']
        ];
        arsort($rating);
        $classBtnLatest = \App\Helpers\ValidataHelper::getButtonClassLatest($rating);

        if (isset($people['sbs_latest']['detail'])) {
            foreach($people['sbs_latest']['detail'] as $key => $value) {
                $latestAmount += $value['amount'];
            }
        }
        if (isset($people['sbs_latest']['report_date'])) {
            $latest = $people['sbs_latest']['report_date'];
        }
    }
    setlocale(LC_TIME, 'es_ES.UTF-8');
    $latestTmp = date("Y-m", strtotime($latest));
    $latestTmp = $latestTmp."-01";
    for($i = 0; $i <=3; $i++) {
        $timeTmp = strtotime($latestTmp." -".(3-$i)." month");
        $index = date("Y-m", $timeTmp);
        $latestMonth[$index] = strtoupper(strftime("%B %Y", $timeTmp));
    }

    if (isset($people['sbs_two_years'])) {
        foreach($people['sbs_two_years'] as $key => $value) {
            $valueTmp = [
                "normal_rating"     =>  (int)$value['normal_rating'],
                "cpp_rating"        =>  (int)$value['cpp_rating'],
                "deficient_rating"  =>  (int)$value['deficient_rating'],
                "uncertain_rating"  =>  (int)$value['uncertain_rating'],
                "lost_rating"       =>  (int)$value['lost_rating']
            ];
            arsort($valueTmp);
            $tmpReportDate = date("Y-m", strtotime($value['report_date']));
            $tmpReportDate = $tmpReportDate."-01";
            $keyReportDate = date("Y-m", strtotime($tmpReportDate));
            $sbsTwoYears[$keyReportDate] = $valueTmp;

            if (isset($latestMonth[$keyReportDate])) {
                $sbsLatestMonthRating[$keyReportDate] = "";
                $k = 0;
                foreach($valueTmp as $key3 => $value3) {
                    if ($k == 0) {
                        $sbsLatestMonthRating[$keyReportDate] = $key3;
                    }
                    $k++;
                }
                $detailTmp = $value['detail'];
                foreach($detailTmp as $key2 => $value2) {
                    $creditType = $value2['credit_type'];
                    $entity = $value2['entity'];
                    if (!isset($sbsLatestMonth[$entity])) {
                        $sbsLatestMonth[$entity] = [];
                    }
                    if (!isset($sbsLatestMonth[$entity][$creditType])) {
                        $sbsLatestMonth[$entity][$creditType] = [];
                    }
                    if (!isset($sbsLatestMonth[$entity][$creditType][$keyReportDate])) {
                        $sbsLatestMonth[$entity][$creditType][$keyReportDate] = [];
                    }
                    $sbsLatestMonth[$entity][$creditType][$keyReportDate][] = $value2;
                }
            }
        }
    }
    foreach($latestMonth as $key => $value) {
        foreach($sbsLatestMonth as $key2 => $value2) {
            foreach($value2 as $key3 => $value3) {
                if (!isset($value3[$key])) {
                    $sbsLatestMonth[$key2][$key3][$key] = [];
                }
            }
        }
    }

@endphp

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12 col-md-offset-0">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row col-md-offset-0">
                            @include("validata.reporte-sbs.partial._partial_header_sbs")
                        </div>
                        <hr>
                        <div class="row col-md-offset-0">
                            <div class="col-sm-1">
                                @include("validata.reporte-sbs.partial._partial_table_ratings_sbs")
                            </div>
                            <div class="col-sm-10 table-responsive">
                                <table id="tableRatingsSbsHistorico" class="table">
                                    <tbody>
                                        @for($i = 0; $i < 4; $i++)
                                            <tr>
                                                @foreach($monthsLatestTwoYears as $key => $value)
                                                    <td>@include(\App\Helpers\ValidataHelper::getViewButtonStatusSbs($i, $key, $sbsTwoYears))</td>
                                                @endforeach
                                            </tr>
                                        @endfor
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            @foreach($monthsLatestTwoYears as $key => $value)
                                                <th>{{$value}}</th>
                                            @endforeach
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <div class="row col-md-offset-0">
                            <h5>Detalle de Deuda</h5>
                            <div class="col-sm-12 table-responsive">
                                @include("validata.reporte-sbs.partial._partial_table_detail_debt")
                            </div>
                        </div>
                        <div class="row col-md-offset-0" id="legend">
                            <div class="col-sm-12">
                                <label class="label-rating label-normal"><b>NOR</b></label>
                                <span>Normal</span>
                                <label class="label-rating label-cpp"><b>CPP</b></label>
                                <span>Con Problemas Potenciales</span>
                                <label class="label-rating label-deficient"><b>DEF</b></label>
                                <span>Deficiente</span>
                                <label class="label-rating label-uncertain"><b>DUD</b></label>
                                <span>Dudoso</span>
                                <label class="label-rating label-lost"><b>PER</b></label>
                                <span>Pérdida</span>
                                <label class="label-rating label-unrated"><b>SCAL</b></label>
                                <span>Sin Calificación</span>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default btn-flat" href="{{ route('validata_reporte_sbs_index') }}"><i class="fa fa-chevron-left"></i> Volver</a>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
    <div id="modal-essalud" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-essalud">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection
