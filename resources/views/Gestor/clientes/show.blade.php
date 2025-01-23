@extends('adminlte::page')

@section('htmlheader_title')
    GESTOR CRDIAL
@endsection

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> BUSCAR CLIENTES
@endsection

@section('contentheader_description')
    GESTOR CRDIAL
@endsection

@section('contentheader_breadcrumb')
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
    <li class="active">BUSCAR CLIENTES</li>
</ol>
@endsection

@section('main-content')
<body>
    <div style="margin: 0px auto; padding: 20px;">
        <!-- First Row -->
        <div style="display: flex; flex-wrap: wrap; gap: 20px;">
            <!-- Primera Vista: Datos del Cliente -->
            <div style="flex: 1; max-width: 30%; background-color: white; padding: 0px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                    <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white; text-transform: uppercase;">DATOS DEL CLIENTE</h2>
                </div>
                <!-- Contenido del Box -->
                <div style="padding: 20px;">
                    <div style="text-align: center; margin-bottom: 10px;">
                        <div style="width: 50px; height: 50px; background-color: #e0e0e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;">
                            <img class="profile-user-img img-responsive img-circle" src="{{ asset('img/user.png') }}" alt="User profile picture">
                        </div>
                        <p id="nombreCliente" style="font-size: 17px; font-weight: bold; color: #333; margin: 0; text-transform: uppercase;"></p>
                    </div>
                    <!-- Datos del Cliente -->
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">DNI / RUC</label>
                            <p id="dniCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">EDAD</label>
                            <p id="edadCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">CORREO ELECTRONICO</label>
                            <p id="correoCliente" style="margin: 0; color: #333; font-size: 11.5px;">
                                <a href="mailto:example@gmail.com" style="color: #2196F3; text-decoration: none;"></a>
                            </p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">DIRECCION</label>
                            <p id="direccionCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">DEPARTAMENTO</label>
                            <p id="departamentoCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">PROVINCIA</label>
                            <p id="provinciaCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                        <div style="background-color: #f5f5f5; padding: 8px 12px; border-radius: 4px; grid-column: 1 / -1;">
                            <label style="font-size: 12px; font-weight: bold; color: #333;">DISTRITO</label>
                            <p id="distritoCliente" style="margin: 0; color: #333; font-size: 11.5px;"></p>
                        </div>
                    </div>
                    <!-- Fin Datos del Cliente -->
                </div>
                <!-- Fin Contenido del Box -->
            </div>
            <!-- Fin Primera Vista -->

            <!-- Segunda Vista: Datos Adicionales Del Cliente -->
            <div style="flex: 1; min-width: 30%; background-color: #ffffff; border: 0px solid #d3d3d3; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); overflow-x: auto;">
                <!-- Encabezado del Box -->
                <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                    <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">DATOS ADICIONALES BANCO</h2>
                </div>
                <!-- Contenido del Box -->
                <div id="data-container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 15px; margin-top: 0px; align-items: center; gap: 10px; padding: 15px;">
                    
                </div>
                <!-- Fin Contenido del Box -->
            </div>
            <!-- Fin Segunda Vista -->
        </div>
        <!-- Fin First Row -->

        <!-- Botones de navegación -->
        <div style="display: flex; justify-content: center; gap: 10px; margin: 20px 0px;">
            <button onclick="showView('details')" id="btnDetails" style="padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; background: #3c8dbc; color: white;">Detalles y Reportes</button>
            <button onclick="showView('massive')" id="btnMassive" style="padding: 10px 20px; border: 1px solid #3c8dbc; border-radius: 4px; cursor: pointer; background: white; color: #3c8dbc;">Gestión Masiva</button>
            <button onclick="showView('sbs')" id="btnSbs" style="padding: 10px 20px; border: 1px solid #0066cc; border-radius: 4px; cursor: pointer; background: white; color: #0066cc; min-width: 150px;">Reporte SBS</button>
        </div>

        <!-- Details View -->
        <div id="detailsView">
            <!-- Second Row -->
            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Primera Tabla: Detalle de Deuda -->
                <div style="width:100%; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 4px; border-top-right-radius: 4px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">DETALLE DEUDA</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <table style="border-collapse: collapse; width: 100%;">
                        <thead>
                            <tr id="table-headers" style="background: #f5f5f5;">
                                <!-- Los encabezados se llenarán dinámicamente -->
                                <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Seleccionar</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            <!-- Las filas de datos se llenarán dinámicamente -->
                        </tbody>
                    </table>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Primera Tabla -->
            </div>
            <!-- Fin Second Row -->

            <!-- Third Row -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-bottom: 15px;">
                <!-- Reporte de Pagos del Mes -->
                <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">REPORTE DE PAGOS DEL MES</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <div style="padding: 0px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f0f0f0;">
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">N° CUENTAS</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">PRODUCTO</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">CARTERA</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">FECHA</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="payments-table-body">
                                <!-- Dynamically populated rows will appear here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="padding: 12px 8px; text-align: right; font-weight: bold; font-size: 14px;">TOTAL</td>
                                    <td id="total-monto" style="padding: 12px 8px; text-align: right; font-weight: bold; font-size: 14px;">0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Reporte de Pagos del Mes -->

                <!-- Reporte de Pagos Historico -->
                <div style="background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">REPORTE DE PAGOS HISTORICO</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <div style="padding: 0px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background-color: #f0f0f0;">
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">N° CUENTAS</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">PRODUCTO</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">CARTERA</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">FECHA</th>
                                    <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; font-size: 14px;">MONTO</th>
                                </tr>
                            </thead>
                            <tbody id="historical-payments-table-body">
                                <!-- Dynamically populated rows will appear here -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="padding: 12px 8px; text-align: right; font-weight: bold; font-size: 14px;">TOTAL</td>
                                    <td id="historical-total-monto" style="padding: 12px 8px; text-align: right; font-weight: bold; font-size: 14px;">0.00</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Reporte de Pagos Historico -->
            </div>
            <!-- Fin Third Row -->

            <!-- Fourth Row -->
            <!-- Reporte de Gestiones -->
            <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                <!-- Encabezado del Box -->
                <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                    <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">FOTO GESTIÓN DEL MES</h2>
                </div>
                <!-- Contenido del Box -->
                <div style="padding: 1px;">
                    <table style="width: 100%; border-collapse: collapse; text-align: left;">
                        <thead>
                            <tr style="background-color: #f0f0f0;">
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">FECHA GESTIÓN</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">HORA GESTIÓN</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">MARCACIÓN</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">ESTADO</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">COD GESTOR</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">NUM CTA</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">TELÉFONO</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">ORIGEN</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">FECHA PDP</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">MONTO PDP</th>
                                <th style="padding: 12px 8px; text-align: center; border: 1px solid #dee2e6;">COMENTARIO</th>
                            </tr>
                        </thead>
                        <tbody id="management-table-body">
                            <!-- Aquí se insertarán los datos -->
                        </tbody>
                    </table>

                    <!-- Paginación -->
                    <div id="pagination-controls" style="text-align: center; margin: 15px 0px;">
                        <button id="prev-btn" onclick="changePage(-1)">Anterior</button>
                        <span id="page-info"></span>
                        <button id="next-btn" onclick="changePage(1)">Siguiente</button>
                    </div>
                </div>
                <!-- Fin Contenido del Box -->
            </div>
            <!-- Fin Fourth Row -->
        </div>
        <!-- Fin Details View -->

        <!-- Massive View -->
        <div id="massiveView" style="display: none;">
            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Primera Tabla: Masivo SMS -->
                <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">MASIVO SMS</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <table id id="smsTable" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f5f5f5;">
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">FECHA</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">TELEFONO</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">MENSAJE</th>
                            </tr>
                        </thead>
                        <tbody id="smsTableBody">
                            <!-- Filas dinámicas -->
                        </tbody>
                    </table>

                    <!-- Mensaje sin datos -->
                    <div id="noDataMessageSMS" style="display: none; text-align: center; margin: 20px; color: #555; font-weight: bold;">
                        No hay mensajes disponibles
                    </div>

                    <!-- Paginación -->
                    <div id="paginacion-smsmasivo" style="margin-top: 15px; text-align: center;">
                        <!-- Botones de paginación -->
                    </div>

                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Primera Tabla -->
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Segunda Tabla: Masivo WhatsApp -->
                <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">MASIVO WHATSAPP</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <table id="wspTable" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f5f5f5;">
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">FECHA</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">TELEFONO</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">MENSAJE</th>
                            </tr>
                        </thead>
                        <tbody id="wspTableBody">
                            <!-- Filas dinámicas -->
                        </tbody>
                    </table>

                    <!-- Mensaje sin datos -->
                    <div id="noDataMessageWSP" style="display: none; text-align: center; margin: 20px; color: #555; font-weight: bold;">
                        No hay mensajes disponibles
                    </div>

                    <!-- Paginación -->
                    <div id="paginacion-wspmasivo" style="margin-top: 15px; text-align: center;">
                        <!-- Botones de paginación -->
                    </div>

                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Segunda Tabla -->
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Tercera Tabla: Masivo IVR -->
                <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                        <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">MASIVO IVR</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <table id="ivrTable" style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f5f5f5;">
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">CARTERA</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">FECHA GESTION</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">HORA GESTION</th>
                                <th style="padding: 10px; text-align: center; border: 1px solid #dee2e6;">ESTADO GESTION</th>
                            </tr>
                        </thead>
                        <tbody id="ivrTableBody">
                            <!-- Filas dinámicas -->
                        </tbody>
                    </table>

                    <!-- Mensaje sin datos -->
                    <div id="noDataMessageIVR" style="display: none; text-align: center; margin: 20px; color: #555; font-weight: bold;">
                        No hay mensajes disponibles
                    </div>

                    <!-- Paginación -->
                    <div id="paginacion-ivrmasivo" style="margin-top: 15px; text-align: center;">
                        <!-- Botones de paginación -->
                    </div>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Tercera Tabla -->
            </div>
        </div>
        <!-- Fin Massive View -->
        
        <!-- View Reporte SBS -->
        <div id="sbsView" style="display: none;">
            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Primera fila: Situación Financiera -->
                <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                            <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">SITUACION FINANCIERA</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f5f5f5;">
                                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: 600;">Entidad Financiera</th>
                                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: 600;">Monto</th>
                                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: 600;">Calificación</th>
                                    <th style="padding: 12px; text-align: center; border: 1px solid #dee2e6; font-weight: 600;">Días Atraso</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Banco de Crédito</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">S/ 15,000.00</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Normal</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">0</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">BBVA</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">S/ 8,500.00</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Normal</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Primera fila -->
            </div>
            
            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <!-- Segunda Fila: Resumen SBS --> 
                <div style="width: 100%; background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); overflow-x: auto;">
                    <!-- Encabezado del Box -->
                    <div style="background-color: #3c8dbc; padding: 12px 16px; border-top-left-radius: 8px; border-top-right-radius: 8px; text-align: center;">
                            <h2 style="margin: 0; font-size: 16px; font-weight: bold; color: white;">RESUMEN SBS</h2>
                    </div>
                    <!-- Contenido del Box -->
                    <div style="overflow-x: auto;">
                        <table id='resumenSBS' style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="background: #f5f5f5;">
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-weight: 600;">RUC</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-weight: 600;">Empresa</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-weight: 600;">Periodo</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-weight: 600;">Condición</th>
                                    <th style="padding: 12px; text-align: left; border-bottom: 1px solid #ddd; font-weight: 600;">Sueldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">20100047218</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Empresa ABC S.A.C.</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">2023-12</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Activo</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">S/ 4,500.00</td>
                                </tr>
                                <tr>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">20131312955</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Empresa XYZ S.A.</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">2023-11</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">Activo</td>
                                    <td style="padding: 12px; border-bottom: 1px solid #ddd;">S/ 4,500.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Fin Contenido del Box -->
                </div>
                <!-- Fin Segunda Fila -->
            </div>
        </div>
        <!-- Fin View Reporte SBS -->

    </div>
</body>

<script>

// APARTADO DETALLE DEUDA
    // Script actual para obtener y mostrar datos del cliente
    document.addEventListener('DOMContentLoaded', async () => {
    const apiUrl = "http://192.168.2.72:5001/maestra/dataprivate";
    const localData = {
        dni: localStorage.getItem('dni'),
        num_cta: localStorage.getItem('num_cta'),
        campania: localStorage.getItem('campania') // Asegúrate de almacenar 'campania' también
    };

    console.log(localData); // Para verificar si los datos están cargando correctamente

    if (localData.dni && localData.campania) {
        try {
            const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(localData)
                });

                if (!response.ok) {
                    const errorDetails = await response.text();
                    throw new Error(`Error al consultar el API: ${response.status} - ${errorDetails}`);
                }

                const data = await response.json();
                console.log('Datos obtenidos:', data); // Verifica la respuesta

                document.getElementById('nombreCliente').textContent = data.cNOM_CLIENTE || 'Nombre no disponible';
                document.getElementById('dniCliente').textContent = data.cNUM_DOCUMENTO || 'DNI no disponible';
                document.getElementById('edadCliente').textContent = data.nEDAD || 'Edad no disponible';
                document.getElementById('correoCliente').innerHTML = `<a href="mailto:${data.cCOR_CLIENTE}" style="color: #2196F3; text-decoration: none;">${data.cCOR_CLIENTE}</a>` || 'Correo no disponible';
                document.getElementById('direccionCliente').textContent = data.cDIR_CLIENTE || 'Dirección no disponible';
                document.getElementById('departamentoCliente').textContent = data.cDEPARTAMENTO_CLIENTE || 'Departamento no disponible';
                document.getElementById('provinciaCliente').textContent = data.cPROVINCIA_CLIENTE || 'Provincia no disponible';
                document.getElementById('distritoCliente').textContent = data.cDISTRITO_CLIENTE || 'Distrito no disponible';

        } catch (error) {
            console.error('Error al obtener los datos del cliente:', error);
        }
    }
});

    // Script nuevo para obtener y mostrar los pagos del mes
    async function fetchPayments() {
        const dni = localStorage.getItem('dni');
        const cta = localStorage.getItem('num_cta');
        const campania = localStorage.getItem('campania');

        if (!dni || !campania) {
            console.error("Faltan datos necesarios en localStorage.");
            return;
        }

        // Calcular el periodo actual (YYYYMM)
        const today = new Date();
        const currentPeriod = `${today.getFullYear()}${String(today.getMonth() + 1).padStart(2, '0')}`;

        try {
            const response = await fetch('http://192.168.2.72:5001/maestra/pagos', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    dni: dni,
                    cta: cta,
                    campania: campania,
                    periodo: currentPeriod,
                }),
            });

            if (!response.ok) {
                throw new Error('Error en la solicitud');
            }

            const data = await response.json();
            populatePaymentsTable(data); // Llamar a la función para llenar la tabla con los datos
        } catch (error) {
            console.error('Error fetching payments:', error);
        }
    }

    // Función para llenar la tabla con los pagos
    function populatePaymentsTable(data) {
        const tbody = document.getElementById('payments-table-body');
        const totalMontoElement = document.getElementById('total-monto');
        let totalMonto = 0;

        // Limpiar las filas actuales de la tabla
        tbody.innerHTML = '';

        // Iterar sobre los datos y agregar las filas
        data.forEach(payment => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td style="padding: 12px 8px; font-size: 14px;">${payment.cNUM_CUENTA}</td>
                <td style="padding: 12px 8px; font-size: 14px;">${payment.cTIP_PRODUCTO}</td>
                <td style="padding: 12px 8px; font-size: 14px;">${payment.cCAMPAIGN_ID}</td>
                <td style="padding: 12px 8px; font-size: 14px;">${payment.dFECHA_PAGO}</td>
                <td style="padding: 12px 8px; text-align: right; font-size: 14px;">${payment.nMONTO_CONSIDERADO}</td>
            `;

            tbody.appendChild(row);
            totalMonto += payment.nMONTO_CONSIDERADO; // Sumar al total
        });

        // Mostrar el total en la tabla
        totalMontoElement.textContent = totalMonto.toFixed(2);
    }

    // Script nuevo para obtener y mostrar los pagos históricos
async function fetchHistoricalPayments() {
    const dni = localStorage.getItem('dni');
    const cta = localStorage.getItem('num_cta');
    const campania = localStorage.getItem('campania');

    if (!dni || !campania) {
        console.error("Faltan datos necesarios en localStorage.");
        return;
    }

    try {
        const response = await fetch('http://192.168.2.72:5001/maestra/pagos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                dni: dni,
                cta: cta,
                campania: campania,
            }),
        });

        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        const data = await response.json();
        populateHistoricalPaymentsTable(data); // Llamar a la función para llenar la tabla con los datos históricos
    } catch (error) {
        console.error('Error fetching historical payments:', error);
    }
}

// Función para llenar la tabla con los pagos históricos
function populateHistoricalPaymentsTable(data) {
    const tbody = document.getElementById('historical-payments-table-body');
    const totalMontoElement = document.getElementById('historical-total-monto');
    let totalMonto = 0;

    // Limpiar las filas actuales de la tabla
    tbody.innerHTML = '';

    // Iterar sobre los datos y agregar las filas
    data.forEach(payment => {
        const row = document.createElement('tr');

        row.innerHTML = `
            <td style="padding: 12px 8px; font-size: 14px;">${payment.cNUM_CUENTA}</td>
            <td style="padding: 12px 8px; font-size: 14px;">${payment.cTIP_PRODUCTO}</td>
            <td style="padding: 12px 8px; font-size: 14px;">${payment.cCAMPAIGN_ID}</td>
            <td style="padding: 12px 8px; font-size: 14px;">${payment.dFECHA_PAGO}</td>
            <td style="padding: 12px 8px; text-align: right; font-size: 14px;">${payment.nMONTO_CONSIDERADO}</td>
        `;

        tbody.appendChild(row);
        totalMonto += payment.nMONTO_CONSIDERADO; // Sumar al total
    });

    // Mostrar el total en la tabla
    totalMontoElement.textContent = totalMonto.toFixed(2);
}

    //Script para capturar las gestiones del cliente y mostrarlas en la tabla paginada
    const rowsPerPage = 10;
    let currentPage = 1;
    let totalPages = 1;
    let allData = []; // Aquí almacenaremos todos los resultados

    // Función para hacer la consulta al API
    async function fetchData() {
        const requestData = {
            "dni": localStorage.getItem("dni"),
            "num_cta": localStorage.getItem("num_cta"),
            "campania": localStorage.getItem("campania")
        };

        try {
            const response = await fetch('http://192.168.2.72:5001/maestra/gestiones', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(requestData),
            });

            const data = await response.json();
            allData = data; // Asignamos los resultados a la variable global
            totalPages = Math.ceil(allData.length / rowsPerPage);
            displayPage(currentPage); // Muestra la primera página
        } catch (error) {
            console.error('Error al obtener los datos:', error);
        }
    }

    // Función para cambiar de página
    function changePage(direction) {
        currentPage += direction;
        if (currentPage < 1) currentPage = 1;
        if (currentPage > totalPages) currentPage = totalPages;
        displayPage(currentPage);
    }

    // Función para mostrar los datos de la página actual
    function displayPage(page) {
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const pageData = allData.slice(startIndex, endIndex);

        const tbody = document.getElementById('management-table-body');
        tbody.innerHTML = ''; // Limpiar la tabla

        pageData.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.FEC_GESTION}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.HOR_GESTION}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.MARCACION}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.ESTADO}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.COD_GESTOR}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.NUM_CTA}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.TELEFONO}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.ORIGEN}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.FECHA_PDP}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.MONTO_PDP}</td>
                <td style="padding: 12px 8px; border: 1px solid #dee2e6;">${item.COMENTARIO}</td>
            `;
            tbody.appendChild(row);
        });

        document.getElementById('page-info').innerText = `Página ${currentPage} de ${totalPages}`;
        document.getElementById('prev-btn').disabled = currentPage === 1;
        document.getElementById('next-btn').disabled = currentPage === totalPages;
    }

    // Inicializar datos al cargar la página
    window.onload = fetchData;
    
        // Nuevo script para cargar datos adicionales
        document.addEventListener('DOMContentLoaded', async () => {
        const apiAdditionalUrl = "http://192.168.2.72:5001/maestra/dataaditional";

        // Recuperar datos del localStorage
        const localData = {
            dni: localStorage.getItem('dni'),
            num_cta: localStorage.getItem('num_cta'),
            campania: localStorage.getItem('campania')
        };

        console.log("Datos recuperados de localStorage:", localData);

        // Validar que los datos requeridos estén disponibles
        if (localData.dni && localData.campania) {
            try {
                // Realizar la solicitud al endpoint
                const response = await fetch(apiAdditionalUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(localData)
                });

                if (!response.ok) {
                    const errorDetails = await response.text();
                    throw new Error(`Error al consultar el API: ${response.status} - ${errorDetails}`);
                }

                // Obtener los datos de la respuesta
                const additionalData = await response.json();
                console.log("Datos adicionales obtenidos:", additionalData);

                // Renderizar los datos dinámicamente en el contenedor
                const container = document.getElementById('data-container');

                // Limpiar el contenedor antes de agregar nuevos datos
                container.innerHTML = '';

                // Iterar sobre las claves y valores para renderizarlos
                Object.entries(additionalData).forEach(([key, value], index) => {
                    if (index > 1) { // Ignorar las dos primeras filas (por ejemplo: cNUM_DOCUMENTO y cNUM_CUENTA)
                        const itemDiv = document.createElement('div');
                        itemDiv.style.width = '100%';
                        itemDiv.style.padding = '10px';
                        itemDiv.style.textAlign = 'center';
                        itemDiv.style.backgroundColor = '#f8f8f8';
                        itemDiv.style.border = '1px solid #d3d3d3';
                        itemDiv.style.borderRadius = '5px';

                        const titleDiv = document.createElement('div');
                        titleDiv.style.fontWeight = 'bold';
                        titleDiv.style.color = '#333';
                        titleDiv.textContent = key.replace(/_/g, ' ').toUpperCase();

                        const valueDiv = document.createElement('div');
                        valueDiv.style.color = '#555';
                        valueDiv.textContent = value?? 'No Asignado';

                        itemDiv.appendChild(titleDiv);
                        itemDiv.appendChild(valueDiv);
                        container.appendChild(itemDiv);
                    }
                });
            } catch (error) {
                console.error("Error al cargar los datos adicionales:", error);
            }
        } else {
            console.warn("Datos insuficientes en localStorage para realizar la solicitud.");
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
    const endpoint = "http://192.168.2.72:5001/maestra/detalledeuda";

    // Recuperar los datos del localStorage
    const campania = localStorage.getItem("campania");
    const dni = localStorage.getItem("dni");
    const num_cta = localStorage.getItem("num_cta");

    // Configurar los parámetros de la solicitud
    const requestData = {
        campania: campania || "",
        dni: dni || "",
        num_cta: num_cta || ""
    };

    // Realizar la solicitud POST
    fetch(endpoint, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(requestData)
    })
        .then(response => response.json())
        .then(data => {
            populateTable(data);
        })
        .catch(error => console.error("Error al obtener los datos:", error));
});

// Función para llenar la tabla dinámicamente
function populateTable(data) {
    const headersRow = document.getElementById("table-headers");
    const tableBody = document.getElementById("table-body");

    // Limpiar contenido previo
    headersRow.innerHTML = '<th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Seleccionar</th>';
    tableBody.innerHTML = "";

    if (Array.isArray(data) && data.length > 0) {
        // Extraer las claves como encabezados desde el primer elemento, excluyendo `cNUM_DOCUMENTO`
        const headers = Object.keys(data[0]).filter(header => header !== "cNUM_DOCUMENTO");

        // Crear los encabezados dinámicamente
        headers.forEach(header => {
            const th = document.createElement("th");
            th.style.padding = "10px";
            th.style.textAlign = "left";
            th.style.borderBottom = "1px solid #ddd";
            th.textContent = header.toUpperCase();
            headersRow.appendChild(th);
        });

        // Crear las filas dinámicamente
        data.forEach((rowData, rowIndex) => {
            const row = document.createElement("tr");

            // Crear celda para checkbox
            const checkboxTd = document.createElement("td");
            checkboxTd.style.padding = "10px";
            checkboxTd.style.borderBottom = "1px solid #ddd";

            const checkbox = document.createElement("input");
            checkbox.type = "checkbox";
            checkbox.style.transform = "scale(1.5)";
            checkbox.dataset.rowIndex = rowIndex; // Vincular índice de fila
            checkbox.addEventListener("change", () => updateColumnSums(data, headers)); // Recalcular sumas al cambiar selección
            checkboxTd.appendChild(checkbox);
            row.appendChild(checkboxTd);

            // Crear celdas para los valores de cada columna
            headers.forEach(header => {
                const td = document.createElement("td");
                td.style.padding = "10px";
                td.style.borderBottom = "1px solid #ddd";

                const value = rowData[header];
                td.textContent = value || ""; // Mostrar el valor o vacío si no existe
                row.appendChild(td);
            });

            tableBody.appendChild(row);
        });

        // Agregar fila para las sumas totales
        const totalRow = document.createElement("tr");
        totalRow.id = "totals-row"; // Identificar fila de totales
        totalRow.style.fontWeight = "bold";

        // Celda vacía para el checkbox
        const totalCheckboxTd = document.createElement("td");
        totalCheckboxTd.style.padding = "10px";
        totalCheckboxTd.style.borderBottom = "1px solid #ddd";
        totalCheckboxTd.textContent = "TOTAL";
        totalRow.appendChild(totalCheckboxTd);

        // Crear celdas para las sumas por columna
        headers.forEach(() => {
            const td = document.createElement("td");
            td.style.padding = "10px";
            td.style.borderBottom = "1px solid #ddd";
            td.textContent = "0.00"; // Iniciar con 0.00
            totalRow.appendChild(td);
        });

        tableBody.appendChild(totalRow);
    } else {
        // Si no hay datos, mostrar mensaje
        const noDataRow = document.createElement("tr");
        const noDataTd = document.createElement("td");
        noDataTd.colSpan = 2;
        noDataTd.style.padding = "10px";
        noDataTd.style.textAlign = "center";
        noDataTd.textContent = "No se encontraron datos";
        noDataRow.appendChild(noDataTd);
        tableBody.appendChild(noDataRow);
    }
}

// Función para actualizar las sumas dinámicas por columna
function updateColumnSums(data, headers) {
    const tableBody = document.getElementById("table-body");
    const totalRow = document.getElementById("totals-row");

    if (!totalRow) return;

    // Reiniciar las sumas
    const columnSums = headers.map(() => 0);

    // Iterar sobre las filas y actualizar las sumas si están seleccionadas
    Array.from(tableBody.children).forEach((row, rowIndex) => {
        const checkbox = row.querySelector("input[type='checkbox']");

        if (checkbox && checkbox.checked) {
            // Acumular las sumas de las columnas de la fila seleccionada
            headers.forEach((header, colIndex) => {
                const value = parseFloat(data[rowIndex][header]);
                if (!isNaN(value)) {
                    columnSums[colIndex] += value;
                }
            });
        }
    });

    // Actualizar los totales en la fila de totales
    Array.from(totalRow.children).slice(1).forEach((cell, index) => {
        cell.textContent = columnSums[index].toFixed(2);
    });
}

    // Llamar a la función fetchPayments para obtener los pagos al cargar la página
    document.addEventListener('DOMContentLoaded', fetchPayments);
    document.addEventListener('DOMContentLoaded', fetchHistoricalPayments);


// APARTADO MASIVOS DETALLE

    // Script para cargar los datos de los masivos WSP
        document.addEventListener('DOMContentLoaded', async () => {
        const apiUrlWsp = "http://192.168.2.72:5001/maestra/wspmasivo";

        // Obtener valores del localStorage
        const dni = localStorage.getItem('dni') || '';
        const numCta = localStorage.getItem('num_cta') || '';

        // Realizar la consulta a la API
        const fetchData = async () => {
            try {
                const response = await fetch(apiUrlWsp, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ dni, num_cta: numCta })
                });

                if (!response.ok) throw new Error('Error en la respuesta del servidor');

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error al obtener los datos:', error);
                return [];
            }
        };

        // Renderizar los datos en la tabla
        const renderTable = (data, page = 1, rowsPerPage = 5) => {
            const tableBody = document.getElementById('wspTableBody');
            const paginationDiv = document.getElementById('paginacion-wspmasivo');
            const noDataMessageWSP = document.getElementById('noDataMessageWSP');
            tableBody.innerHTML = ''; // Limpiar tabla
            paginationDiv.innerHTML = ''; // Limpiar paginación

            if (data.length === 0) {
                noDataMessageWSP.style.display = 'block'; // Mostrar mensaje
                return;
            } else {
                noDataMessageWSP.style.display = 'none'; // Ocultar mensaje
            }

            // Paginación
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            paginatedData.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.FECHA}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.TELEFONO}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.MENSAJE}</td>
                `;
                tableBody.appendChild(tr);
            });

            // Renderizar botones de paginación
            paginationDiv.innerHTML = '';
            const totalPages = Math.ceil(data.length / rowsPerPage);

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.style.margin = '0 5px';
                button.style.padding = '5px 10px';
                button.style.cursor = 'pointer';
                button.style.backgroundColor = i === page ? '#3c8dbc' : '#f5f5f5';
                button.style.color = i === page ? '#fff' : '#000';

                button.addEventListener('click', () => renderTable(data, i, rowsPerPage));
                paginationDiv.appendChild(button);
            }
        };

        // Inicializar tabla
        const data = await fetchData();
        renderTable(data);
    });

    // Script para cargar los datos de los masivos SMS
    document.addEventListener('DOMContentLoaded', async () => {
        const apiUrlSms = "http://192.168.2.72:5001/maestra/smsmasivo"; // Cambiar a tu endpoint para SMS si es diferente

        // Obtener valores del localStorage
        const dni = localStorage.getItem('dni') || '';
        const numCta = localStorage.getItem('num_cta') || '';

        // Realizar la consulta a la API
        const fetchData = async () => {
            try {
                const response = await fetch(apiUrlSms, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ dni, num_cta: numCta })
                });

                if (!response.ok) throw new Error('Error en la respuesta del servidor');

                const data = await response.json();
                return data;
            } catch (error) {
                console.error('Error al obtener los datos:', error);
                return [];
            }
        };

        // Renderizar los datos en la tabla
        const renderTable = (data, page = 1, rowsPerPage = 5) => {
            const tableBody = document.getElementById('smsTableBody');
            const paginationDiv = document.getElementById('paginacion-smsmasivo');
            const noDataMessageSMS = document.getElementById('noDataMessageSMS');
            tableBody.innerHTML = ''; // Limpiar tabla
            paginationDiv.innerHTML = ''; // Limpiar paginación

            if (data.length === 0) {
                noDataMessageSMS.style.display = 'block'; // Mostrar mensaje
                return;
            } else {
                noDataMessageSMS.style.display = 'none'; // Ocultar mensaje
            }

            // Paginación
            const startIndex = (page - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const paginatedData = data.slice(startIndex, endIndex);

            paginatedData.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.FECHA}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.TELEFONO}</td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.MENSAJE}</td>
                `;
                tableBody.appendChild(tr);
            });

            // Renderizar botones de paginación
            paginationDiv.innerHTML = '';
            const totalPages = Math.ceil(data.length / rowsPerPage);

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.style.margin = '0 5px';
                button.style.padding = '5px 10px';
                button.style.cursor = 'pointer';
                button.style.backgroundColor = i === page ? '#3c8dbc' : '#f5f5f5';
                button.style.color = i === page ? '#fff' : '#000';

                button.addEventListener('click', () => renderTable(data, i, rowsPerPage));
                paginationDiv.appendChild(button);
            }
        };

        // Inicializar tabla
        const data = await fetchData();
        renderTable(data);
    });

    // Script para cargar los datos de los masivos IVR
    document.addEventListener('DOMContentLoaded', async () => {
    const apiUrlIvr = "http://192.168.2.72:5001/maestra/ivrmasivo";

    // Obtener valores del localStorage
    const dni = localStorage.getItem('dni') || '';
    
    // Realizar la consulta a la API
    const fetchData = async () => {
        try {
            const response = await fetch(apiUrlIvr, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ dni })
            });

            if (!response.ok) throw new Error('Error en la respuesta del servidor');

            const result = await response.json();
            return result || []; // Ajusta si la respuesta de la API contiene un array directamente
        } catch (error) {
            console.error('Error al obtener los datos:', error);
            return [];
        }
    };

    // Renderizar los datos en la tabla
    const renderTable = (data, page = 1, rowsPerPage = 5) => {
        const tableBody = document.getElementById('ivrTableBody');
        const paginationDiv = document.getElementById('paginacion-ivrmasivo');
        const noDataMessageIVR = document.getElementById('noDataMessageIVR');
        tableBody.innerHTML = ''; // Limpiar tabla
        paginationDiv.innerHTML = ''; // Limpiar paginación

        if (data.length === 0) {
            noDataMessageIVR.style.display = 'block'; // Mostrar mensaje
            return;
        } else {
            noDataMessageIVR.style.display = 'none'; // Ocultar mensaje
        }

        // Paginación
        const startIndex = (page - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const paginatedData = data.slice(startIndex, endIndex);

        paginatedData.forEach(row => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.campaign_id || 'N/A'}</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.FEC_GESTION || 'N/A'}</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.HOR_GESTION || 'N/A'}</td>
                <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">${row.status || 'N/A'}</td>
            `;
            tableBody.appendChild(tr);
        });

        // Renderizar botones de paginación
        const totalPages = Math.ceil(data.length / rowsPerPage);

        for (let i = 1; i <= totalPages; i++) {
            const button = document.createElement('button');
            button.textContent = i;
            button.style.margin = '0 5px';
            button.style.padding = '5px 10px';
            button.style.cursor = 'pointer';
            button.style.backgroundColor = i === page ? '#3c8dbc' : '#f5f5f5';
            button.style.color = i === page ? '#fff' : '#000';

            button.addEventListener('click', () => renderTable(data, i, rowsPerPage));
            paginationDiv.appendChild(button);
        }
    };

    // Inicializar tabla
    const data = await fetchData();
    renderTable(data);
    });

// APARTADO REPORTE SBS







    // Función para cargar los datos de los masivos
    /*function showView(view) {
            const detailsView = document.getElementById('detailsView');
            const massiveView = document.getElementById('massiveView');
            const btnDetails = document.getElementById('btnDetails');
            const btnMassive = document.getElementById('btnMassive');

            if (view === 'details') {
                detailsView.style.display = 'block';
                massiveView.style.display = 'none';
                btnDetails.style.background = '#3c8dbc';
                btnDetails.style.color = 'white';
                btnMassive.style.background = 'white';
                btnMassive.style.color = '#0066cc';
            } else {
                detailsView.style.display = 'none';
                massiveView.style.display = 'block';
                btnDetails.style.background = 'white';
                btnDetails.style.color = '#0066cc';
                btnMassive.style.background = '#3c8dbc';
                btnMassive.style.color = 'white';
            }
    }*/
    function showView(view) {
            const detailsView = document.getElementById('detailsView');
            const massiveView = document.getElementById('massiveView');
            const sbsView = document.getElementById('sbsView');

            const btnDetails = document.getElementById('btnDetails');
            const btnMassive = document.getElementById('btnMassive');
            const btnSbs = document.getElementById('btnSbs');

            // Ocultar todas las vistas
            detailsView.style.display = 'none';
            massiveView.style.display = 'none';
            sbsView.style.display = 'none';

            // Resetear estilos de botones
            btnDetails.style.background = 'white';
            btnDetails.style.color = '#0066cc';

            btnMassive.style.background = 'white';
            btnMassive.style.color = '#0066cc';

            btnSbs.style.background = 'white';
            btnSbs.style.color = '#0066cc';

            // Mostrar la vista seleccionada y activar el botón correspondiente
            if (view === 'details') {
                detailsView.style.display = 'block';
                btnDetails.style.background = '#0066cc';
                btnDetails.style.color = 'white';
            } else if (view === 'massive') {
                massiveView.style.display = 'block';
                btnMassive.style.background = '#0066cc';
                btnMassive.style.color = 'white';
            } else if (view === 'sbs') {
                sbsView.style.display = 'block';
                btnSbs.style.background = '#0066cc';
                btnSbs.style.color = 'white';
            }
        }


</script>
@endsection