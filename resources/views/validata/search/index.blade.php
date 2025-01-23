@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-heartbeat"></i> Validata Log
@endsection
@section('contentheader_description')
    Búsqueda Validata
@endsection
@section('htmlheader_title')
    Búsqueda Validata
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Búsqueda Validata</li>
    </ol>
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-validata, #men-validata-search').addClass('active');
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#data').keydown(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
            $('#data').change(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
        });
    </script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">

                <div class="box box-primary box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Búsqueda</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <form action="{{ route('validata.search.exportXls') }}" method="post">
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
                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-search"></i> Consultar</button>
                        </div>
                    </form>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
