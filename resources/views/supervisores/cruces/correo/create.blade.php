@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> Correo
@endsection
@section('contentheader_description')
    Correo
@endsection
@section('htmlheader_title')
    Correo
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('javascript')
<script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{asset('js/dataTables.dataTables.min.js')}}"></script>
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

@section('jquery')
    <script type="text/javascript" src="{{ asset('/js/jquery.Jcrop.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/plugins/custom-input-file/js/custominputfile.min.js') }}"></script>
    @php
        $jsVersion = config("crreportes.assets.js");
        $correoJs = asset("js/supervisores/correo.js?v={$jsVersion}");
    @endphp
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#data').keydown(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
            $('#data').change(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
        });
        $(".sidebar-toggle").click();
    </script>
    <script type="text/javascript" src="{{ $correoJs }}"></script>
    <script type="text/javascript">
        UploadCorreo.list();
    </script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Correo</h3>
                        <div class="box-tools pull-right">
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('supervisores_cruces_correo_show') }}" method="post">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group">
                                <span class="pull-right">Cantidad: <span class="text-success" id="cont-data">0</span></span>
                                <label class="control-label" for="data">DNI a Consultar</label>
                                <textarea class="form-control" cols="20" id="data" name="data" rows="5" required></textarea>
                            </div>
                            <blockquote class="blockquote-reverse">
                                <small>Separe con <kbd>Enter</kbd> los registros a consultar</small>
                            </blockquote>
                        </div>
                        <div class="box-footer">
                            <div class="row">
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Consultar</button>
                                </div>
                                <div class="col-md-8 pull-right">
                                    <button type="button" class="btn btn-warning btn-flat pull-right" id="uploadCorreo"><i class="fa fa-upload"></i> Cargar</button>
                                    <br>
                                    <a href="{{ route('supervisores_cruces_correo_download_template') }}" style="color: black; width: 100%; display: block; margin-top: 20px; text-align: right; text-decoration: underline;">Descargar Plantilla para Carga de Correos</a>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-md-6">
                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Listado de Cargas de Correo</h3>
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
@include("supervisores.cruces.correo.mdlUpload")
@endsection
