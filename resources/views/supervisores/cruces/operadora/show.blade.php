

@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-phone"></i> Supervisores
@endsection
@section('contentheader_description')
    Cruces por Operadoras
@endsection
@section('htmlheader_title')
    Cruces por Operadoras
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('stylesheet')
    {{--<link href="{{ asset('/css/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css"/>--}}
    {{--<link href="{{ asset('/css/buttons.bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>--}}
    <link rel="stylesheet" type="text/css"
          href="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.css"/>
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
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.18/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/datatables.min.js"></script>
    {{--<script src="{{ asset('/js/dataTables.buttons.min.js') }}" type="text/javascript"></script>--}}
    {{--<script src="{{ asset('/js/buttons.bootstrap.min.js') }}" type="text/javascript"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>--}}
    {{--<script src="{{ asset('/js/buttons.print.min.js') }}" type="text/javascript"></script>--}}
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-super, #men-super-ope').addClass('active');
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#modal-essalud').on('show.bs.modal', function (e) {
                let button = $(e.relatedTarget);
                let dni = button.data('dni');
                let target = '{{ route('supervisores_cruces_essalud_show_modal', ['dni' => '']) }}/' + dni;
                if (button.data('dni')) {
                    $("#modal-essalud .modal-content").html('<div style=" text-align: center; margin-top: 10px;" ><li class="fa fa-refresh fa-5x fa-spin" ></li> <h3>Espere por favor...</h3></div>');
                    $("#modal-essalud .modal-content").load(target, function () {
                    });
                }
            });

            let groupColumn = 0;
            let table = $("#tDatos").dataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Excel',
                        className: 'btn btn-success btn-flat',
                        title: "ReporteXLS___"+(new Date()).getTime(),
                        key: {
                            key: 'e',
                            altKey: true
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        className: 'btn btn-danger btn-flat',
                        title: "ReportePDF___"+(new Date()).getTime(),
                        key: {
                            key: 'f',
                            altKey: true
                        }
                    },
                ],
                ordering: false,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    "loadingRecords": "<i class='fa fa-spinner fa-spin' ></i> Cargando información..."
                },
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('supervisores_cruces_operadora_store') }}",
                    dataType: "json",
                    data: {data: '{{ $data }}', filter: '{{ $filter }}' },
                    type: 'POST',
                    cache: true
                },
                columns: [
                    {"data": "dni"},
                    {"data": "nombre"},
                    {"data": "telefono"},
                    {"data": "operador"},
                    {"data": "updated_at", sorteable: false},
                    {"data": "flagWhatsapp", sorteable: false}
                ],
                columnDefs: [
                    {"visible": false, "targets": groupColumn},
                    {"visible": false, "targets": 1}
                ],
                order: [[groupColumn, 'asc']],
                drawCallback: function (settings) {
                    let api = this.api();
                    let rows = api.rows({page: 'current'}).nodes();
                    let last = null;

                    let rowsData = api.rows({page: 'current'}).data();

                    api.column(groupColumn, {page: 'current'}).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before(
                                '<tr class="group"><td class="details-control" colspan="4"><span class="fa fa-user" ></span> DNI: <a href="#" data-target="#modal-essalud" data-toggle="modal" data-dni="' + rowsData[i].dni + '" >' + group + '</a> - ' + rowsData[i].nombre + '</td></tr>'
                            );

                            last = group;
                        }
                    });
                }
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
                                <th>Nombre</th>
                                <th>Tel&eacute;fono</th>
                                <th>Proviene</th>
                                <th>Ult.Actualización</th>
                                <th>¿Con Whatsapp?</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <a class="btn btn-default btn-flat" href="{{ route('supervisores_cruces_operadora_create') }}"><i
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