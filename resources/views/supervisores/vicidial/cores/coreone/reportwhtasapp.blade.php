@extends('adminlte::page')

@section('htmlheader_title')
    Reportes CRDIAL
@endsection

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> Supervisores
@endsection

@section('contentheader_description')
    Reportes CRDIAL
@endsection

@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('main-content')
<div class="container-fluid spark-screen">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center mb-4" style="font-size: 28px; font-weight: 600;">REPORTES DESCARGA WHATSAPP</h1>

            <div class="row">
                <!-- Filtros -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filtros de Reporte</h3>
                        </div>
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="loadDate">Fecha Carga</label>
                                        <input type="date" id="fcargar" name="loadDate" class="form-control">
                                        <script>
                                         document.getElementById('fcargar').value = new Date().toISOString().split('T')[0];
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="chatStartDate">Fecha Inicio Chat</label>
                                        <input type="date" id="fchat" name="chatStartDate" class="form-control">
                                        <script>
                                         document.getElementById('fchat').value = new Date().toISOString().split('T')[0];
                                        </script>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="device">Dispositivo</label>
                                        <select id="device" name="device" class="form-control">
                                            <option value="ANDROID">ANDROID</option>
                                            <option value="IOS">IOS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="campaign">Campaña</label>
                                        <select id="campaigns"  name="campaign" class="form-control">
                                            <option value="all">Todos</option>
                                            
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                <div class="form-group">
                                <label for="celular">Celular </label>
                             <input type="number" id="celular" name="classification" class="form-control" placeholder="Ingresa un número" />
                                        </div>
                                </div>
                               
                        </div>
                    </div>
                </div>
                </div>
                </div>
                

                <!-- Tabla de Reportes -->
                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Resultados de Busqueda</h3>
                        </div>
                        <div class="box-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>F.Carga</th>
                                        <th>F.Inicio Chat</th>
                                        <th>Nombre de Archivo</th>
                                        <th>Campaña</th>
                                        <th>Clasificación</th>
                                        <th>T.Dispositivo</th>
                                        <th>Documento</th>
                                        <th>Teléfono</th>
                                        <th>Usuario</th>
                                    </tr>
                                </thead>
                                <tbody id="reportTableBody">
                                    <!-- Los resultados de la API se cargarán aquí -->
                                </tbody>
                            </table>

                            <!-- Paginación -->
                            <div class="text-center">
                                <button id="previousPage" class="btn btn-primary" disabled>Anterior</button>
                                <button id="nextPage" class="btn btn-primary">Siguiente</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const campaignsSelect = document.getElementById("campaigns");
    const fechacargaInput = document.getElementById("fcargar");
    const fechatInput = document.getElementById("fchat");
    const deviceSelect = document.getElementById("device");
    const reportTableBody = document.getElementById("reportTableBody");
    const previousPageBtn = document.getElementById("previousPage");
    const nextPageBtn = document.getElementById("nextPage");
    const searchBtn = document.getElementById("searchButton");
    const celularInput = document.getElementById("celular");

    let currentPage = 1;
    const pageSize = 20;
    let allReports = [];

    // Función para cargar los reportes de la API sin filtro
    function loadReports() {
        fetch("http://192.168.1.6:3000/test/get-reports", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({}) 
        })
        .then(response => response.json())
        .then(data => {
            allReports = data;
            updateTable(allReports);
        })
        .catch(error => {
            console.error("Error al cargar los reportes:", error);
        });
    }

    // Función para actualizar la tabla con los reportes filtrados y paginados
    function updateTable(reportsToDisplay) {
        reportTableBody.innerHTML = "";

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = Math.min(startIndex + pageSize, reportsToDisplay.length);

        const pageReports = reportsToDisplay.slice(startIndex, endIndex);

        pageReports.forEach(item => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${item["F.CARGA"]}</td>
                <td>${item["F.InicioChat"]}</td>
                <td><button class="btn btn-success" onclick="fetchReportText(${item['ID']})">${item["NOMBRE_ARCHIVO"]}</button></td>
                <td>${item["CAMPAÑA"]}</td>
                <td>${item["CLASIFICACION"]}</td>
                <td>${item["T.DISPOSITIVO"]}</td>
                <td>${item["DOCUMENTO"]}</td>
                <td>${item["TELEFONO"]}</td>
                <td>${item["USUARIO"]}</td>
            `;
            reportTableBody.appendChild(row);
        });

        previousPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage * pageSize >= reportsToDisplay.length;
    }

    // Función para descargar el archivo .txt
    function downloadTextFile(archivo, texto) {
        const blob = new Blob([texto], { type: "text/plain;charset=utf-8" });
        const link = document.createElement("a");
        link.href = URL.createObjectURL(blob);
        link.download = archivo + ".txt"; 
        link.click();
    }

    // Función para obtener el texto del reporte usando el ID
    window.fetchReportText = function(reportId) {
    fetch("http://192.168.1.6:3000/test/generate", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ id: reportId }) 
    })
    .then(response => response.json())
    .then(data => {
        const texto = data.TEXTO;
        // Usamos el campo "archivo" para obtener el nombre del archivo
        const archivo = data.archivo || "reporte"; // Si "archivo" está vacío, usamos "reporte"
        
        // Escapamos caracteres no válidos para un nombre de archivo
        const safeArchivo = archivo.replace(/[\/:*?"<>|]/g, "_");

        // Llamamos a la función para descargar el archivo .txt
        downloadTextFile(safeArchivo, texto); 
    })
    .catch(error => {
        console.error("Error al obtener el reporte:", error);
    });
}

// Función para descargar el archivo .txt
function downloadTextFile(archivo, texto) {
    const blob = new Blob([texto], { type: "text/plain;charset=utf-8" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = archivo + ".txt"; // Usamos el nombre de archivo ajustado
    link.click();
}
    // Filtro por campaña
    campaignsSelect.addEventListener("change", function () {
        applyFilters();
    });

    // Filtro por fecha de carga 
    fechacargaInput.addEventListener("input", function () {
        applyFilters();
    });

    // Filtro por fecha de carga fechatInput
    fechatInput.addEventListener("input", function () {
        applyFilters();
    });

    // Filtro por device
    deviceSelect.addEventListener("change", function () {
        applyFilters();
    });

    // Filtro por celular
    celularInput.addEventListener("input", function () {
        applyFilters();
    });

    // Función para aplicar todos los filtros
    function applyFilters() {
        const selectedCampaign = campaignsSelect.value;
        const selectedFechaCarga = fechacargaInput.value;
        const selectedFechat = fechatInput.value;
        const selecteddevice = deviceSelect.value;
        const selectedCelular = celularInput.value;

        let filteredReports = allReports;

        if (selectedCampaign !== 'all' && selectedCampaign) {
            filteredReports = filteredReports.filter(item => item["CAMPAÑA"] === selectedCampaign);
        }

        if (selecteddevice !== 'ANDROID' && selecteddevice) {
            filteredReports = filteredReports.filter(item => item["T.DISPOSITIVO"] === selecteddevice);
        }

        if (selectedFechaCarga) {
            filteredReports = filteredReports.filter(item => {
                const fechaCarga = item["F.CARGA"];
                return fechaCarga === selectedFechaCarga;
            });
        }

        if (selectedFechat) {
            filteredReports = filteredReports.filter(item => {
                const fechaCarga = item["F.InicioChat"];
                return fechaCarga === selectedFechat;
            });
        }

        if (selectedCelular) {
            filteredReports = filteredReports.filter(item => {
                const telefono = item["TELEFONO"];
                return telefono.includes(selectedCelular);  
            });
        }

        updateTable(filteredReports);
    }

    // Cargar campañas disponibles
    fetch("http://192.168.1.6:3000/test/campid")
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                throw new Error("No hay campañas disponibles.");
            }
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item.campaign_id;
                option.textContent = item.campaign_id;
                campaignsSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error("Error al cargar las campañas:", error);
        });

    // Cargar los reportes inicialmente sin filtro
    loadReports();

    // Manejo de los botones de paginación
    previousPageBtn.addEventListener("click", function () {
        if (currentPage > 1) {
            currentPage--;
            updateTable(allReports);
        }
    });

    nextPageBtn.addEventListener("click", function () {
        if (currentPage * pageSize < allReports.length) {
            currentPage++;
            updateTable(allReports);
        }
    });
});
</script>
@endsection
