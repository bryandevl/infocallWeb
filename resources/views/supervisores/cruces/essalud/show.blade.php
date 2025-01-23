@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-heartbeat"></i> EsSalud
@endsection
@section('contentheader_description')
    EsSalud
@endsection
@section('htmlheader_title')
    EsSalud
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Operaciones</li>
    </ol>
@endsection

@section('stylesheet')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.css"/>
    <style type="text/css">
        tr.group,
        tr.group:hover {
            background-color: #ddd !important;
        }
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.js"></script>
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-super, #men-super-ess').addClass('active');
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $("#tDatos").dataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<span class="fa fa-excel-o"></span> Excel',
                        className: 'btn btn-success',
                        title: '',
                        key: {
                            key: 'e',
                            altKey: true
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<span class="fa fa-pdf-o"></span> PDF',
                        className: 'btn btn-danger',
                        title: '',
                        key: {
                            key: 'f',
                            altKey: true
                        }
                    },
                ],
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('supervisores_cruces_essalud_store') }}",
                    dataType: "json",
                    data: { data: '{{ $data }}' },
                    type: 'POST',
                    cache: true
                },
                columns: [
                    { "data": "documento"  },
                    { "data": "ruc" },
                    { "data": "empresa" },
                    { "data": "periodo" },
                    { "data": "condicion" },
                    { "data": "sueldo", 'class' : 'text-right' }
                ],
                order: [[0, 'asc']]
            });
        });
    </script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">

                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultado de la Busqueda</h3>
                        <div class="box-tools pull-right">
                            {{--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                        class="fa fa-minus"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover table-striped" id="tDatos">
                            <thead>
                            <tr>
                                <th>DNI</th>
                                <th>RUC</th>
                                <th>Empresa</th>
                                <th>Periodo</th>
                                <th>Condici&oacute;n</th>
                                <th>Sueldo</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default btn-flat" href="{{ route('supervisores_cruces_essalud_create') }}"><i
                                    class="fa fa-chevron-left"></i> Volver</a>
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
