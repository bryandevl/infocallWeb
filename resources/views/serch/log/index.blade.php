@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-key-o"></i> Serch Log
@endsection
@section('contentheader_description')
    Reporte de Transacciones
@endsection
@section('htmlheader_title')
    Reporte de Transaccione
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Serch Log - Reporte de Transaccione</li>
    </ol>
@endsection

@section('stylesheet')
<link rel="stylesheet" type="text/css" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
    <style type="text/css">
        tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
        .modal-header .close {
            margin-top: -25px;
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.dataTables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/datepicker/js/bootstrap-datepicker.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-serch, #men-serch-dni').addClass('active');
    </script>
    <script src="//code.highcharts.com/highcharts.js"></script>
    <script src="//code.highcharts.com/modules/series-label.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script type="text/javascript" src="{{asset('js/serch/log.js')}}"></script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary box-solid">
                    <div class="box-body">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab-resumen" id="nav-tab-info">Resumen</a></li>
                            <li><a data-toggle="tab" href="#tab-search">Búsqueda</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-resumen" class="tab-pane fade in active">
                                @include("serch.log.tab.resumen")
                            </div>
                            <div id="tab-search" class="tab-pane fade">
                                @include("serch.log.tab.search")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("serch.log.mdlDetail")
@endsection
