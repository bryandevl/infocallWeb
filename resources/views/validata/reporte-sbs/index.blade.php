@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-key-o"></i> Validata
@endsection
@section('contentheader_description')
    Reporte SBS por DNI
@endsection
@section('htmlheader_title')
    Reporte SBS por DNI
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Validata - Reporte SBS por DNI</li>
    </ol>
@endsection

@section('stylesheet')
    <style type="text/css">
        tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
        .modal-header .close {
            margin-top: -25px;
        }
        #formSearch input{text-transform: uppercase;}
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{asset('js/dataTables.dataTables.min.js')}}"></script>
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-validata, #men-validata-reporte-sbs').addClass('active');
        var tableSearch = $("#tSearchValidata").DataTable({
            'language': {
                'url': '/Spanish.json'
            }
        });
    </script>
    <script type="text/javascript" src="{{asset('js/validata/default.js')}}"></script>
@endsection

@section('main-content')
    <input type="hidden" name="actionFormSearch" value="{{route('validata_custom_search')}}">
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="box box-primary box-solid">
                            <div class="box-body">
                                @include("validata.partial._partial_form_search")
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="box box-success box-solid">
                            @include("validata.partial._partial_result_search")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="urlReporteSbsResult" value="{{\URL('')}}/validata/reporte-sbs-get/" />
@endsection