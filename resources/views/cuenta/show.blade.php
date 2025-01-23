@extends('adminlte::layouts.app')

@section('contentheader_title')
    <i class="fa fa-address-card-o"></i> Cuenta DNI
@endsection
@section('htmlheader_title')
    Cuenta DNI
@endsection
@section('contentheader_description')
    {{ $cuenta->documento }}
@endsection
@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Operadores</a></li>
        <li class="active"><i class="fa fa-dashboard"></i> Cuenta DNI</li>
    </ol>
@endsection

@section('jquery')
<script type="text/javascript">
    $('#men-oper, #men-oper-dni').addClass('active');
    $(document).ready(function() {
        var documento = "{{ $cuenta->documento }}"; // Obtener el documento de la cuenta

        // Convertir el valor de documento a número (por si está como string)
        var documentoNumero = parseInt(documento, 10);

        // Verificar si la conversión fue correcta
        console.log('Documento como número:', documentoNumero);

        // Realizar la solicitud AJAX para obtener datos de SBS
        $.ajax({
            url: 'http://192.168.1.6:5000/test/getSBS', // URL de la API
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                "documento": [documentoNumero] // Enviar el documento como número
            }),
            success: function(response) {
                // Limpiar la tabla antes de añadir los datos
                $('#sbs-table-body').empty();

                // Si la respuesta es válida, agregar filas a la tabla
                if (response.length > 0) {
                    var sbsData = response[0]; // Obtener el primer registro
                    var newRow = `
                        <tr>
                            <td class="text-center">${sbsData.documento}</td>
                            <td class="text-center">${sbsData.cod_sbs}</td>
                            <td class="text-center">${sbsData.fecha_reporte_sbs}</td>
                            <td class="text-center">${sbsData.ruc}</td>
                            <td class="text-center">${sbsData.cant_empresas}</td>
                            <td class="text-center" style="background-color: #00A65A;">${sbsData.calificacion_normal}</td> <!-- Color verde para Normal -->
                            <td class="text-center" style="background-color: #45b116;">${sbsData.calificacion_cpp}</td> <!-- Color verde claro para CPP -->
                            <td class="text-center" style="background-color: #d2df1d;">${sbsData.calificacion_deficiente}</td>
                            <td class="text-center" style="background-color: #e98a0a;">${sbsData.calificacion_dudoso}</td>
                            <td class="text-center" style="background-color: #d93c15;">${sbsData.calificacion_perdida}</td>
                        </tr>
                    `;
                    $('#sbs-table-body').append(newRow);

                    // Ahora realizar la segunda solicitud AJAX para obtener detalles de SBS
                    $.ajax({
                        url: 'http://192.168.1.6:5000/test/getSBSDETALLE', // URL de la API
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            "documento": [documentoNumero]  //documentoNumero, // Enviar el documento como número
                            //"fecha_reporte": sbsData.fecha_reporte_sbs // Puedes ajustar esto si tienes otro valor
                        }),
                        success: function(sbsDetailResponse) {
                            // Limpiar la tabla de detalles antes de añadir los datos
                            $('#sbsdet-table-body').empty();

                            // Si la respuesta de detalles es válida, agregar filas a la tabla
                            if (sbsDetailResponse.length > 0) {
                                sbsDetailResponse.forEach(sbsDet => {
                                    var detailRow = `
                                        <tr>
                                            <td class="text-center">${sbsDet.documento}</td>
                                            <td class="text-center">${sbsDet.fecha_reporte}</td>
                                            <td class="text-center">${sbsDet.ruc}</td>
                                            <td class="text-center">${sbsDet.cod_sbs}</td>
                                            <td class="text-center">${sbsDet.entidad}</td>
                                            <td class="text-center">${sbsDet.tipo_credito}</td>
                                            <td class="text-center">${sbsDet.condicion}</td>
                                            <td class="text-center">${sbsDet.saldo}</td>
                                            <td class="text-center">${sbsDet.dias_atraso}</td>
                                        </tr>
                                    `;
                                    $('#sbsdet-table-body').append(detailRow);
                                });
                            } else {
                                // Mostrar mensaje si no hay datos
                                $('#sbsdet-table-body').append('<tr><td colspan="9" class="text-center">No hay datos de SBS para este documento</td></tr>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error en detalles:', error);
                            $('#sbsdet-table-body').append('<tr><td colspan="9" class="text-center">Error al obtener los detalles de SBS</td></tr>');
                        }
                    });

                } else {
                    // Mostrar mensaje si no hay datos
                    $('#sbs-table-body').append('<tr><td colspan="10" class="text-center">No hay datos de SBS para este documento</td></tr>');
                }
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                console.log('Estado:', status);
                console.log('Respuesta:', xhr.responseText);
                $('#sbs-table-body').append('<tr><td colspan="10" class="text-center">Error al obtener los datos de SBS</td></tr>');
            }
        });
    });
</script>
@endsection



@section('main-content')
    <div class="row">
        <div class="col-md-3">
            <!-- Perfil -->
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user.png') }}"
                         alt="User profile picture">
                    <h3 class="profile-username text-center">{{ $cuenta->apellido_pat }} {{ $cuenta->apellido_mat }}, {{ $cuenta->nombre }}</h3>
                    <p class="text-muted text-center"><strong>DNI:</strong> {{ $cuenta->documento }}</p>
                    <p class="text-muted text-center"><strong>Fecha Nac.</strong> {{ date_format($cuenta->fec_nac, 'd/m/Y') }}</p>
                </div>
            </div>

            <!-- Información adicional (familiares, conyuge, etc.) -->
            @php
                $hermanos = collect([]);
                $hermanos = $hermanos->merge(($cuenta->hermanos)?? []);
                $hermanos = $hermanos->merge(($cuenta->hermanosOld)?? []);
                
                $familiares = collect([]);
                $familiares = $familiares->merge(($cuenta->familiares)?? []);
                $familiares = $familiares->merge(($cuenta->familiaresOld)?? []);
                
                $conyuge = $conyuge?? null;
                if (is_null($conyuge)) {
                    $conyuge = $conyugeOld?? null;
                }
            @endphp

            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Acerca de</h3>
                </div>
                <div class="box-body">
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Datos</strong>
                    <p><small><strong>Sexo:</strong></small> @if($cuenta->sexo == 1) <i class="fa fa-male"></i> Masculino @else <i class="fa fa-female"></i> Femenino @endif</p>
                    <p><small><strong>Madre:</strong></small> {{ $cuenta->nombre_mad }}</p>
                    <p><small><strong>Padre:</strong></small> {{ $cuenta->nombre_pat }}</p>
                    <hr>
                    <strong><i class="fa fa-map-marker margin-r-5"></i> Dirección</strong>
                    <p class="text-muted">{{ $cuenta->direccion }}</p>
                    <p class="text-muted">{{ $cuenta->ubigeo }}</p>
                    <p class="text-muted">{{ $cuenta->ubigeo_dir }}</p>
                    <hr>
                    <strong><i class="fa fa-phone margin-r-5"></i> Teléfonos</strong>
                    <p><small><strong>Claro:</strong></small>
                        @foreach($cuenta->claro as $item)
                            <span class="label label-danger">{{ $item->numero }}</span>
                        @endforeach
                    </p>
                    <p><small><strong>Entel:</strong></small>
                        @foreach($cuenta->entel as $item)
                            <span class="label label-primary">{{ $item->numero }}</span>
                        @endforeach
                    </p>
                    <p><small><strong>Movistar:</strong></small>
                        @foreach($cuenta->movistar as $item)
                            <span class="label label-success">{{ $item->numero }}</span>
                        @endforeach
                    </p>
                    <p><small><strong>Movistar Fijo:</strong></small>
                        @foreach($cuenta->movistar_fijo as $item)
                            <span class="label label-success">{{ $item->numero }}</span>
                        @endforeach
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#datos" data-toggle="tab">Datos</a></li>
                </ul>
                <div class="tab-content">
                    <div class="active tab-pane" id="datos">
                        <!-- Sección EsSalud -->
                        <h3>EsSalud</h3>
                        <div class="panel panel-primary table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                <tr>
                                    <th class="text-center">Periodo</th>
                                    <th class="text-center">Condición</th>
                                    <th class="text-center">Empresa</th>
                                    <th class="text-center">RUC</th>
                                    <th class="text-center">Sueldo</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cuenta->essalud as $item)
                                    <tr>
                                        <td class="text-center">{{ $item->periodo }}</td>
                                        <td class="text-center">{{ $item->condicion }}</td>
                                        <td>{{ $item->empresa }}</td>
                                        <td class="text-center">{{ $item->ruc }}</td>
                                        <td class="text-right">{{ number_format($item->sueldo, 2, '.', ',') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección Conyuge/Concubina -->
                        <h3>Conyuge/Concubina</h3>
                        <div class="panel panel-info table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">DNI</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Telefonos</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($conyuge)
                                    <tr>
                                        <td class="text-right">{{ $conyuge->doc_parent }}</td>
                                        <td class="text-center">{{ $conyuge->nombre }}</td>
                                        <td>
                                            <ol class="">
                                                @foreach($conyuge->claro as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Claro</li>
                                                @endforeach
                                                @foreach($conyuge->entel as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Entel</li>
                                                @endforeach
                                                @foreach($conyuge->movistar as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar</li>
                                                @endforeach
                                                @foreach($conyuge->movistar_fijo as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar Fijo</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección Hermanos -->
                        <h3>Hermanos</h3>
                        <div class="panel panel-success table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">DNI</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Telefonos</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($hermanos as $item)
                                    <tr>
                                        <td class="text-right">{{ $item->doc_parent }}</td>
                                        <td class="text-center">{{ $item->nombre }}</td>
                                        <td>
                                            <ol class="">
                                                @foreach($item->claro as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Claro</li>
                                                @endforeach
                                                @foreach($item->entel as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Entel</li>
                                                @endforeach
                                                @foreach($item->movistar as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar</li>
                                                @endforeach
                                                @foreach($item->movistar_fijo as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar Fijo</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección Otros Familiares -->
                        <h3>Otros Familiares</h3>
                        <div class="panel panel-danger table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                <tr>
                                    <th class="text-center">DNI</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Telefonos</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($familiares as $item)
                                    <tr>
                                        <td class="text-right">{{ $item->doc_parent }}</td>
                                        <td class="text-center">{{ $item->nombre }}</td>
                                        <td>
                                            <ol class="">
                                                @foreach($item->claro as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Claro</li>
                                                @endforeach
                                                @foreach($item->entel as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Entel</li>
                                                @endforeach
                                                @foreach($item->movistar as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar</li>
                                                @endforeach
                                                @foreach($item->movistar_fijo as $numero)
                                                    <li><strong>{{ $numero->numero }}</strong> - Movistar Fijo</li>
                                                @endforeach
                                            </ol>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Sección SBS -->
                           <!-- Sección SBS -->
                        <h3>SBS</h3>
                        <div class="panel panel-danger table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center"  >DNI</th>
                                        <th class="text-center">Codigo SBS</th>
                                        <th class="text-center">Fecha Reporte</th>
                                        <th class="text-center">RUC</th>
                                        <th class="text-center">Cant. Empresas</th>
                                        <th class="text-center" style="background-color: #00A65A;">Normal</th>
                                        <th class="text-center" style="background-color: #45b116;">CPP</th>
                                        <th class="text-center" style="background-color: #d2df1d;" >Deficiente</th>
                                        <th class="text-center" style="background-color: #e98a0a;" >Dudoso</th>
                                        <th class="text-center" style="background-color: #d93c15;" >Perdida</th>
                                    </tr>
                                </thead>
                                <tbody id="sbs-table-body">
                                    <tr>
                                        <td colspan="10" class="text-center">Cargando datos de SBS...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                      
                      
                      <!-- Sección SBS DETALLE-->
                           <!-- Sección SBS DETALLE -->
                        <h3>SBS DETALLE</h3>
                        <div class="panel panel-danger table-responsive">
                            <table class="table table-condensed table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center"  >DNI</th>
                                        <th class="text-center">fecha Reporte</th>
                                        <th class="text-center">RUC</th>
                                        <th class="text-center">Codigo SBS</th>
                                        <th class="text-center" >Entidad</th>
                                        <th class="text-center">Tipo Credito</th>
                                        <th class="text-center"  >Condicion</th>
                                        <th class="text-center" >Saldo</th>
                                        <th class="text-center"  >Dias Atraso</th>
                                    </tr>
                                </thead>
                                <tbody id="sbsdet-table-body">
                                    <tr>
                                        <td colspan="10" class="text-center">Cargando datos...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                      
                      
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
