@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-users"></i> Reniec
@endsection
@section('contentheader_description')

@endsection
@section('htmlheader_title')
    Reniec
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('stylesheet')
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
@endsection

@section('jquery')
    <script type="text/javascript">
        $('#men-super, #men-super-ren').addClass('active');
    </script>
    <script type="text/javascript">
        $(document).ready(function (e) {
            function format(d) {
                let rowsConyuge = '';
                let rowsNumerosConyuge = '';
                let rowsHermano = '';
                let rowsNumerosHermano = '';
                let rowsFamilia = '';
                let rowsNumerosFamilia = '';

                //Itera el Conyuge/Concubino(a)
                $.each(d.conyuge, function (index, value) {
                    rowsNumerosConyuge = '';
                    $.each(value.telefonos, function (index, value) {
                        console.table(value);
                        rowsNumerosConyuge += '<tr>' + '<td>' + value.telefono + '</td>' + '<td>' + value.operador + '</td>' + '</tr>';
                    });
                    rowsConyuge += '<tr>\n' +
                        '<td>' + value.datos.doc_parent + '</td><td>' + value.datos.nombre + '</td>' +
                        '                    <td>\n' +
                        '                        <table class="table">\n' +
                        '                            <thead>\n' +
                        '                            <tr>\n' +
                        '                                <th>Numero</th>\n' +
                        '                                <th>Operadora</th>\n' +
                        '                            </tr>\n' +
                        '                            </thead>\n' +
                        '                            <tbody>\n' +
                        rowsNumerosConyuge +
                        '                            </tbody>\n' +
                        '                        </table>\n' +
                        '                    </td>\n' +
                        '                </tr>\n';
                });

                //Iterar Hermanos
                $.each(d.hermanos, function (index, value) {
                    rowsNumerosHermano = '';
                    $.each(value.telefonos, function (index, value) {
                        rowsNumerosHermano += '<tr>' + '<td>' + value.telefono + '</td>' + '<td>' + value.operador + '</td>' + '</tr>';
                    });
                    rowsHermano += '<tr>' + '<td>' + value.datos.doc_parent + '</td>' + '<td>' + value.datos.nombre + '</td>' + '<td>' +
                        '                        <table class="table">\n' +
                        '                            <thead>\n' +
                        '                            <tr>\n' +
                        '                                <th>Numero</th>\n' +
                        '                                <th>Operadora</th>\n' +
                        '                            </tr>\n' +
                        '                            </thead>\n' +
                        '                            <tbody>\n' +
                        rowsNumerosHermano +
                        '                            </tbody>\n' +
                        '                        </table>\n' +
                        '                    </td>\n' +
                        '                </tr>\n'
                });

                //Itera Familiares
                $.each(d.familia, function (index, value) {
                    rowsNumerosFamilia = '';
                    $.each(value.telefonos, function (index, value) {
                        rowsNumerosFamilia += '<tr>' + '<td>' + value.telefono + '</td>' + '<td>' + value.operador + '</td>' + '</tr>';
                    });
                    rowsFamilia += '<tr>' + '<td>' + value.datos.doc_parent + '</td>' + '<td>' + value.datos.nombre + '</td>' + '<td>' +
                        '                        <table class="table">\n' +
                        '                            <thead>\n' +
                        '                            <tr>\n' +
                        '                                <th>Numero</th>\n' +
                        '                                <th>Operadora</th>\n' +
                        '                            </tr>\n' +
                        '                            </thead>\n' +
                        '                            <tbody>\n' +
                        rowsNumerosFamilia +
                        '                            </tbody>\n' +
                        '                        </table>\n' +
                        '                    </td>\n' +
                        '                </tr>\n'
                });

                return '<div class="row">\n' +
                    '        <div class="col-md-4">\n' +
                    '            <h4>Datos Conyuge/Concubino(a)</h4>\n' +
                    '            <table class="table table-condensed">\n' +
                    '                <thead>\n' +
                    '                <tr>\n' +
                    '                    <th>Documento</th>\n' +
                    '                    <th>Nombre</th>\n' +
                    '                    <th>Telefonos</th>\n' +
                    '                </tr>\n' +
                    '                </thead>\n' +
                    '                <tbody>\n' +
                    rowsConyuge +
                    '                </tbody>\n' +
                    '            </table>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-4">\n' +
                    '            <h4>Hermanos(as)</h4>\n' +
                    '            <table class="table table-condensed">\n' +
                    '                <thead>\n' +
                    '                <tr>\n' +
                    '                    <th>Documento</th>\n' +
                    '                    <th>Nombre</th>\n' +
                    '                    <th>Telefonos</th>\n' +
                    '                </tr>\n' +
                    '                </thead>\n' +
                    '                <tbody>\n' +
                    rowsHermano +
                    '                </tbody>\n' +
                    '            </table>\n' +
                    '        </div>\n' +
                    '        <div class="col-md-4">\n' +
                    '            <h4>Otros Familiares</h4>\n' +
                    '            <table class="table table-condensed">\n' +
                    '                <thead>\n' +
                    '                <tr>\n' +
                    '                    <th>Documento</th>\n' +
                    '                    <th>Nombre</th>\n' +
                    '                    <th>Telefonos</th>\n' +
                    '                </tr>\n' +
                    '                </thead>\n' +
                    '                <tbody>\n' +
                    rowsFamilia +
                    '                </tbody>\n' +
                    '            </table>\n' +
                    '        </div>\n' +
                    '    </div>';
            }


            let table = $("#tDatos").DataTable({
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="fa fa-excel-o"></i> Excel',
                        className: 'btn btn-success',
                        title: '',
                        key: {
                            key: 'e',
                            altKey: true
                        },
                        customize: function (xlsx) {
                            let data = table.rows().data();

                            //Hoja Conyuge

                            //Add sheet to [Content_Types].xml => <Types>
                            //============================================
                            let source = xlsx['[Content_Types].xml'].getElementsByTagName('Override')[1];
                            let clone = source.cloneNode(true);
                            clone.setAttribute('PartName', '/xl/worksheets/sheet2.xml');
                            xlsx['[Content_Types].xml'].getElementsByTagName('Types')[0].appendChild(clone);

                            //Add sheet relationship to xl/_rels/workbook.xml.rels => Relationships
                            //=====================================================================
                            source = xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationship')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('Id', 'rId3');
                            clone.setAttribute('Target', 'worksheets/sheet2.xml');
                            xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationships')[0].appendChild(clone);

                            //Add second sheet to xl/workbook.xml => <workbook><sheets>
                            //=========================================================
                            source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('name', 'Conyuge');
                            clone.setAttribute('sheetId', '2');
                            clone.setAttribute('r:id', 'rId3');
                            xlsx.xl['workbook.xml'].getElementsByTagName('sheets')[0].appendChild(clone);

                            //Hoja Hermanos

                            //Add sheet to [Content_Types].xml => <Types>
                            //============================================
                            source = xlsx['[Content_Types].xml'].getElementsByTagName('Override')[1];
                            clone = source.cloneNode(true);
                            clone.setAttribute('PartName', '/xl/worksheets/sheet3.xml');
                            xlsx['[Content_Types].xml'].getElementsByTagName('Types')[0].appendChild(clone);

                            //Add sheet relationship to xl/_rels/workbook.xml.rels => Relationships
                            //=====================================================================
                            source = xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationship')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('Id', 'rId4');
                            clone.setAttribute('Target', 'worksheets/sheet3.xml');
                            xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationships')[0].appendChild(clone);

                            //Add second sheet to xl/workbook.xml => <workbook><sheets>
                            //=========================================================
                            source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('name', 'Hermanos');
                            clone.setAttribute('sheetId', '3');
                            clone.setAttribute('r:id', 'rId4');
                            xlsx.xl['workbook.xml'].getElementsByTagName('sheets')[0].appendChild(clone);

                            //Hoja Familia

                            //Add sheet to [Content_Types].xml => <Types>
                            //============================================
                            source = xlsx['[Content_Types].xml'].getElementsByTagName('Override')[1];
                            clone = source.cloneNode(true);
                            clone.setAttribute('PartName', '/xl/worksheets/sheet4.xml');
                            xlsx['[Content_Types].xml'].getElementsByTagName('Types')[0].appendChild(clone);

                            //Add sheet relationship to xl/_rels/workbook.xml.rels => Relationships
                            //=====================================================================
                            source = xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationship')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('Id', 'rId5');
                            clone.setAttribute('Target', 'worksheets/sheet4.xml');
                            xlsx.xl._rels['workbook.xml.rels'].getElementsByTagName('Relationships')[0].appendChild(clone);

                            //Add second sheet to xl/workbook.xml => <workbook><sheets>
                            //=========================================================
                            source = xlsx.xl['workbook.xml'].getElementsByTagName('sheet')[0];
                            clone = source.cloneNode(true);
                            clone.setAttribute('name', 'Familiares');
                            clone.setAttribute('sheetId', '4');
                            clone.setAttribute('r:id', 'rId5');
                            xlsx.xl['workbook.xml'].getElementsByTagName('sheets')[0].appendChild(clone);

                            let rowsConyuges = '';
                            let r = 2;
                            $.each(data, function (index, value) {
                                $.each(data[index].conyuge, function (index, value) {
                                    let datos = value.datos;
                                    $.each(value.telefonos, function (index, value) {
                                        rowsConyuges += '<row r="' + r + '">' +
                                            '<c t="inlinerStr" r="A' + r + '"><is><t>' + datos.documento + '</t></is></c>' +
                                            '<c t="inlinerStr" r="B' + r + '"><is><t>' + datos.doc_parent + '</t></is></c>' +
                                            '<c t="inlinerStr" r="C' + r + '"><is><t>' + datos.nombre + '</t></is></c>' +
                                            '<c t="inlinerStr" r="D' + r + '"><is><t>' + value.telefono + '</t></is></c>' +
                                            '<c t="inlinerStr" r="E' + r + '"><is><t>' + value.operador + '</t></is></c>' +
                                            '</row>';
                                        ++r;
                                    });
                                });
                            });

                            let rowsHermanos = '';
                            r = 2;
                            $.each(data, function (index, value) {
                                $.each(data[index].hermanos, function (index, value) {
                                    let datos = value.datos;
                                    $.each(value.telefonos, function (index, value) {
                                        rowsHermanos += '<row r="' + r + '">' +
                                            '<c t="inlinerStr" r="A' + r + '"><is><t>' + datos.documento + '</t></is></c>' +
                                            '<c t="inlinerStr" r="B' + r + '"><is><t>' + datos.doc_parent + '</t></is></c>' +
                                            '<c t="inlinerStr" r="C' + r + '"><is><t>' + datos.nombre + '</t></is></c>' +
                                            '<c t="inlinerStr" r="D' + r + '"><is><t>' + value.telefono + '</t></is></c>' +
                                            '<c t="inlinerStr" r="E' + r + '"><is><t>' + value.operador + '</t></is></c>' +
                                            '</row>';
                                        ++r;
                                    });
                                });
                            });

                            let rowsFamilia = '';
                            r = 2;
                            $.each(data, function (index, value) {
                                $.each(data[index].familia, function (index, value) {
                                    let datos = value.datos;
                                    $.each(value.telefonos, function (index, value) {
                                        rowsFamilia += '<row r="' + r + '">' +
                                            '<c t="inlinerStr" r="A' + r + '"><is><t>' + datos.documento + '</t></is></c>' +
                                            '<c t="inlinerStr" r="B' + r + '"><is><t>' + datos.doc_parent + '</t></is></c>' +
                                            '<c t="inlinerStr" r="C' + r + '"><is><t>' + datos.nombre + '</t></is></c>' +
                                            '<c t="inlinerStr" r="D' + r + '"><is><t>' + value.telefono + '</t></is></c>' +
                                            '<c t="inlinerStr" r="E' + r + '"><is><t>' + value.operador + '</t></is></c>' +
                                            '</row>';
                                        ++r;
                                    });
                                });
                            });

                            let sheetConyuge = '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes"?>' +
                                '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" mc:Ignorable="x14ac">' +
                                '<cols >' +
                                '<col min="1" max="1" width="10" customWidth="1"/>' +
                                '<col min="2" max="2" width="15" customWidth="1"/>' +
                                '<col min="3" max="3" width="40" customWidth="1"/>' +
                                '<col min="4" max="4" width="10" customWidth="1"/>' +
                                '<col min="5" max="5" width="12" customWidth="1"/>' +
                                '</cols>' +
                                '<sheetData>' +
                                '<row  r="1">' +
                                '<c t="str" r="A1" s="0"><is><t>DNI</t></is></c>' +
                                '<c t="str" r="B1" s="0"><is><t>DNI Conyuge</t></is></c>' +
                                '<c t="str" r="C1" s="0"><is><t>Nombre</t></is></c>' +
                                '<c t="str" r="D1" s="0"><is><t>Telefono</t></is></c>' +
                                '<c t="str" r="E1" s="0"><is><t>Operadora</t></is></c>' +
                                '</row>' +
                                rowsConyuges +
                                '</sheetData>' +
                                '</worksheet>';

                            let sheetHermanos = '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes"?>' +
                                '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" mc:Ignorable="x14ac">' +
                                '<cols >' +
                                '<col min="1" max="1" width="10" customWidth="1"/>' +
                                '<col min="2" max="2" width="15" customWidth="1"/>' +
                                '<col min="3" max="3" width="40" customWidth="1"/>' +
                                '<col min="4" max="4" width="10" customWidth="1"/>' +
                                '<col min="5" max="5" width="12" customWidth="1"/>' +
                                '</cols>' +
                                '<sheetData>' +
                                '<row  r="1">' +
                                '<c t="str" r="A1" s="0"><is><t>DNI</t></is></c>' +
                                '<c t="str" r="B1" s="0"><is><t>DNI Hermano(a)</t></is></c>' +
                                '<c t="str" r="C1" s="0"><is><t>Nombre</t></is></c>' +
                                '<c t="str" r="D1" s="0"><is><t>Telefono</t></is></c>' +
                                '<c t="str" r="E1" s="0"><is><t>Operadora</t></is></c>' +
                                '</row>' +
                                rowsHermanos +
                                '</sheetData>' +
                                '</worksheet>';

                            let sheetFamiliares = '<?xml version = "1.0" encoding = "UTF-8" standalone = "yes"?>' +
                                '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships" xmlns:mc="http://schemas.openxmlformats.org/markup-compatibility/2006" xmlns:x14ac="http://schemas.microsoft.com/office/spreadsheetml/2009/9/ac" mc:Ignorable="x14ac">' +
                                '<cols >' +
                                '<col min="1" max="1" width="10" customWidth="1"/>' +
                                '<col min="2" max="2" width="15" customWidth="1"/>' +
                                '<col min="3" max="3" width="40" customWidth="1"/>' +
                                '<col min="4" max="4" width="10" customWidth="1"/>' +
                                '<col min="5" max="5" width="12" customWidth="1"/>' +
                                '</cols>' +
                                '<sheetData>' +
                                '<row  r="1">' +
                                '<c t="str" r="A1" s="0"><is><t>DNI</t></is></c>' +
                                '<c t="str" r="B1" s="0"><is><t>DNI Familiar</t></is></c>' +
                                '<c t="str" r="C1" s="0"><is><t>Nombre</t></is></c>' +
                                '<c t="str" r="D1" s="0"><is><t>Telefono</t></is></c>' +
                                '<c t="str" r="E1" s="0"><is><t>Operadora</t></is></c>' +
                                '</row>' +
                                rowsFamilia +
                                '</sheetData>' +
                                '</worksheet>';

                            xlsx.xl.worksheets['sheet2.xml'] = $.parseXML(sheetConyuge);
                            xlsx.xl.worksheets['sheet3.xml'] = $.parseXML(sheetHermanos);
                            xlsx.xl.worksheets['sheet4.xml'] = $.parseXML(sheetFamiliares);
                        },
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-pdf-o"></i> PDF',
                        className: 'btn btn-danger',
                        title: '',
                        key: {
                            key: 'f',
                            altKey: true
                        }
                    },
                ],
                lengthMenu: [[50, 100], [50, 100]],
                language: {
                    "loadingRecords": "<i class='fa fa-spinner fa-spin' ></i> Cargando información..."
                },
                ajax: {
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{ route('supervisores_cruces_reniec_store') }}",
                    dataType: "json",
                    data: {data: '{{ $data }}'},
                    type: 'POST',
                    cache: true
                },
                columns: [
                    {
                        className: 'details-control',
                        orderable: false,
                        data: null,
                        defaultContent: '<i class="fa fa-plus-circle"></i>'
                    },
                    {data: "documento"},
                    {data: "nombre"},
                    {data: "apellido_pat"},
                    {data: "apellido_mat"},
                    {data: "fec_nac"},
                    {data: "direccion"},
                    {data: "ubigeo"},
                    {data: "ubigeo_dir"},
                ],
                order: [[1, 'asc']],
            });

            $('#tDatos tbody').on('click', 'td.details-control', function () {
                let tr = $(this).closest('tr');
                let row = table.row(tr);
                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    // console.table(row.data());
                    row.child(format(row.data())).show();
                    tr.addClass('shown');
                }
            });
        });
    </script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
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
                            <th>&nbsp;</th>
                            <th>DNI</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Fecha Nac.</th>
                            <th>Direccion</th>
                            <th>Ubigeo</th>
                            <th>Ubigeo Direcci&oacute;n</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a class="btn btn-default btn-flat" href="{{ route('supervisores_cruces_reniec_create') }}"><i
                                class="fa fa-chevron-left"></i> Volver</a>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    <div id="modal-essalud" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modal-essalud">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection
