@extends('adminlte::page')

@section('contentheader_title')
    <i class="fa fa-key-o"></i> Serch
@endsection
@section('contentheader_description')
    Búsqueda por DNI
@endsection
@section('htmlheader_title')
    Búsqueda por DNI
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Serch - Búsqueda por DNI</li>
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
        textarea{resize: none;}
    </style>
@endsection

@section('javascript')
    <script src="{{ asset('/js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/js/dataTables.bootstrap.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.dataTables.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
@endsection

@section('jquery')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#txt_dni').keydown(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
            $('#txt_dni').change(function (e) {
                $('#cont-data').html($(this).val().split("\n").length)
            });
        });
    </script>
    @php
        $jsVersion = \Config::get("crreportes.assets.js");
        $dniJs = asset("js/serch/dni.js?v={$jsVersion}");
    @endphp
    <script type="text/javascript" src="{{ $dniJs }}"></script>
@endsection

@section('main-content')
    <div class="container-fluid spark-screen">
        <div class="row">
            <div class="col-md-9 col-md-offset-1">
                <div class="box box-primary box-solid">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <span class="pull-right">Cantidad: <span class="text-success" id="cont-data">0</span></span>
                                    <label class="control-label" for="data">DNI a Consultar</label>
                                    <textarea class="form-control" cols="20" name="data" rows="5" required id="txt_dni"></textarea>
                                </div>
                                <blockquote class="blockquote-reverse">
                                    <small>Separe con <kbd>Enter</kbd> los registros a consultar</small>
                                </blockquote>
                            </div>
                            <div class="col-md-3">
                                <br>
                                <button class="btn btn-success" id="btn-search">
                                    <i class="fa fa-search"></i>
                                </button>
                                <button class="btn btn-danger" id="btn-download">
                                    <i class="fa fa-download"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box box-success box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Resultado de la Búsqueda</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <div class="table-responsive-md">
                            <table class="table table-hover table-striped" id="tDatos" style="width:100%">
                                <thead>
                                <tr>
                                    <th>DNI</th>
                                    <th>Nombres</th>
                                    <th>Ap.Paterno</th>
                                    <th>Ap.Materno</th>
                                    <th>[]</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("btn-download").addEventListener("click", function (event) {
        event.preventDefault();

        let dniInput = document.getElementById("txt_dni").value.trim();
        if (!dniInput) {
            alert("Por favor, ingrese al menos un DNI.");
            return;
        }

        let documentos = dniInput.split('\n').map(dni => dni.trim()).filter(Boolean);

        const params = {
            documento: documentos
        };

        const apiUrl = 'http://192.168.1.6:5000/cliente/getOperadorAndFamiliar';

        console.log('Enviando solicitud al servidor...');
        fetch(apiUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(params)
        })
        .then(response => {
            console.log('Respuesta recibida:', response);
            if (!response.ok) {
                console.error('Error en la respuesta:', response);
                throw new Error('Error en la solicitud: ' + response.statusText);
            }
            return response.arrayBuffer();
        })
        .then(arrayBuffer => {
            console.log('ArrayBuffer recibido, descomprimiendo...');
            const zip = new JSZip();
            return zip.loadAsync(arrayBuffer);
        })
        .then(zip => {
            console.log('Archivos en el ZIP:', Object.keys(zip.files));
            const excelFileName = Object.keys(zip.files).find(fileName => fileName.endsWith('.xlsx'));

            if (excelFileName) {
                return zip.files[excelFileName].async("blob");
            } else {
                throw new Error('No se encontró un archivo de Excel en el ZIP.');
            }
        })
        .then(blob => {
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'SEARCH_EXPORT_DNI.xlsx';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Hubo un error en la descarga o descompresión del archivo: ' + error.message);
        });
    });
});


</script>
