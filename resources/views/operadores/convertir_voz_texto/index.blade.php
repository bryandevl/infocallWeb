@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-heartbeat"></i> Operadores
@endsection
@section('contentheader_description')
    Convertir Voz A Texto
@endsection
@section('htmlheader_title')
    Operadores | Convertir Voz A Texto
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Convertir Voz a Texto</li>
    </ol>
@endsection

@section('javascript')
<script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/dataTables.dataTables.min.js')}}"></script>
@endsection

@section('jquery')
<script type="text/javascript" src="{{ asset('/js/jquery.Jcrop.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/custom-input-file/js/custominputfile.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/operadores/convertirTextoAVoz.js') }}?v=202108070344"></script>
<script type="text/javascript">
    TranslateVoiceToText.list();
</script>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="box box-primary box-solid">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Entidad Financiera</label>
                                        <select class="form-control selectpicker" data-live-search="true" data-size="10" id="financeEntityFilter">
                                            <option value="">Todos</option>
                                            @foreach($financeEntities as $key => $value)
                                            <optgroup label="{{$key}}">
                                                @foreach($value as $key2 => $value2)
                                                <option value="{{$value2['id']}}">{{$value2['description']}}</option>
                                                @endforeach
                                            </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Fecha Carga</label>
                                        <input type="date" class="form-control" value="{{date('Y-m-d')}}" placeholder="yyyy-mm-dd" id="uploadDateFilter"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                                <br>
                                <button class="btn btn-success" id="btn-search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="btn btn-warning" id="btn-new">
                                    <i class="fa fa-upload"></i>
                                </button>
                        </div>
                    </div>
                </div>
            </div>
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultado de la Busqueda</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <div class="table-responsive-md">
                            <table class="table table-hover table-striped" id="tDatos" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Ent.Financiera</th>
                                    <th>F.Carga</th>
                                    <th>F.Registro</th>
                                    <th>F.Inicio Proceso</th>
                                    <th>F. Fin Proceso</th>
                                    <th>T.Archivos</th>
                                    <th>T.Procesados</th>
                                    <th>T.No Procesados</th>
                                    <th>Email Not.</th>
                                    <th>Procesado</th>
                                    <th>Notificado</th>
                                    <th>[]</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="box-footer">
                        
                    </div>
                    <!-- /.box-body -->
                </div>
        </div>
    </div>
</div>
@include("operadores.convertir_voz_texto.mdlUpload")
@include("operadores.convertir_voz_texto.mdlDetail")
@endsection

@section("stylesheet")
<link rel="stylesheet" type="text/css" href="{{ asset('/css/jquery.Jcrop.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/plugins/custom-input-file/css/custominputfile.min.css') }}">
<style type="text/css">
    #mdlUploadTitle, #mdlDetailTitle{
        font-size: 20px;
        font-weight: 700;
    }
    #mdlUploadButton, #mdlDetailButton{
        font-size: 35px;
        margin-top: -35px;
    }
    .cif-file-picker{
        display: block;
        width: 100%;
        height: 130px;
    }
    .cif-file-picker h3{
        font-size: 18px;
        font-weight: 700;
    }
    .swal2-popup{
        font-size: 1.5rem;
    }
    .table>thead>tr>th,
    .table>tbody>tr>th,
    .table>tfoot>tr>th,
    .table>thead>tr>td,
    .table>tbody>tr>td,
    .table>tfoot>tr>td{
        text-align: center;
        width: auto !important;
    }
    #tDatosDetail.table>thead>tr>th:first-child,
    #tDatosDetail.table>tbody>tr>th:first-child,
    #tDatosDetail.table>tfoot>tr>th:first-child,
    #tDatosDetail.table>thead>tr>td:first-child,
    #tDatosDetail.table>tbody>tr>td:first-child,
    #tDatosDetail.table>tfoot>tr>td:first-child {
        width: 20px !important;
    }
    #tDatosDetail.table>thead>tr>th:last-child,
    #tDatosDetail.table>tbody>tr>th:last-child,
    #tDatosDetail.table>tfoot>tr>th:last-child,
    #tDatosDetail.table>thead>tr>td:last-child,
    #tDatosDetail.table>tbody>tr>td:last-child,
    #tDatosDetail.table>tfoot>tr>td:last-child {
        width: 20px !important;
    }
    .dropdown-header{font-weight: 700;}
    textarea{resize: none;}
</style>
@endsection