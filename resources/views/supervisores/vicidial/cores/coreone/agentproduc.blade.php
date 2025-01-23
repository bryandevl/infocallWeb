@extends('adminlte::page')

@section('htmlheader_title')
Tiempo Operativo de Gestiones Integral
@endsection

@section('contentheader_title')
 <!--   <i class="fa fa-id-card-o"></i> Supervisores -->
@endsection

@section('contentheader_description')
  <!--   Actualizar CRDIAL -->
@endsection

@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('main-content')

<!DOCTYPE html>
<html lang="es">
<head>
    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <div id='HelpDisplayDiv' class='help_info' style='display:none;'></div>
    <link rel="stylesheet" href="{{ asset('css/operativos.css') }}">
   
  
</head>
<body bgcolor="white" marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">
  

    <div class="container">
        <h1>Tiempo Operativo de Gestiones Integral</h1>
        <div class="flex">
            <div class="flex-column">
                <label for="fechaInicio">Fecha inicio:</label>
                <input type="date" id="fechaInicio" />

                <label for="fechaFin">Fecha Fin:</label>
                <input type="date" id="fechaFin" />
            </div>

            <div class="flex-column bg-muted p-4 rounded-lg shadow-md">
                <label>Campañas:</label>
                <select multiple id="campaigns">
                <option value="all">-- Todas las campañas --</option>
                                </select>
            </div>

            <div class="flex-column bg-muted p-4 rounded-lg shadow-md">
                <label>Grupos De Usuario:</label>
                <select multiple id="gruposUsuario">
                <option value="all">-- Todos los grupos --</option>
                 
                </select>
            </div>
        </div>

        <div class="flex justify-between">
            <button id="enviarBtn" class="button">ENVIAR</button>
            <button class="button-descargar">DESCARGAR XLS</button>
            <button id="reload-button" class="button">Volver a iniciar</button>
   
        </div>
    </div>

    <!-- SecciÃ³n de resultados que estarÃ¡ oculta inicialmente -->
    <div id="resultados-section" class="section" style="display: none;">
        <div class="section-title">Resultados:</div>
        <div class="table-container">
            <table id="resultados-table" class="result">
                <thead>
                    <tr class="table-header">
                        <!-- Cabecera de la tabla -->
                        <th>Usuario</th>
                        <th>IDENTIFICADOR</th>
                        <th>CAMPAÑA</th>
                        <th>Accesos</th>
                        <th>Expulsado</th>
                        <th>Inicio_Logueo</th>
                        <th>FIN_Logueo</th>
                        <th>LLAMADAS</th>
                        <th>CD</th>
                        <th>PDP</th>
                        <th>%CONV</th>
                        <th>Tiempo Logueo</th>
                        <th>Wait</th>
                        <th>%Wait</th>
                        <th>Talk</th>
                        <th>%Talk</th>
                        <th>ACW</th>
                        <th>%ACW</th>
                        <th>Pausa</th>
                        <th>%Pausa</th>
                        <th>Dead Call</th>
                        <th>%Dead</th>
                        <th>AVG TALK</th>
                        <th>AVG ACW</th>
                        <th>AVG WAIT</th>                        
                        <th>undefined</th>
                        <th>ANDIAL</th>
                        <th>BREAK</th>
                        <th>CAPA</th>
                        <th>GES_M</th>
                        <th>LAGGED</th>
                        <th>LOGIN</th>
                        <th>NXDIAL</th>
                        <th>OMNI</th>
                        <th>RRHH</th>
                        <th>SOPO</th>
                        <th>SSHH</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- AquÃ­ se insertarÃ¡n las filas de datos -->
                </tbody>
            </table>
        </div>
    </div>

    

    <script>
document.addEventListener("DOMContentLoaded", async function () {
    const campaignsSelect = document.getElementById("campaigns");
    const groupsSelect = document.getElementById("gruposUsuario");
    const downloadBtn = document.querySelector(".button-descargar");
    const enviarBtn = document.getElementById("enviarBtn");
    const tableBody = document.querySelector("#resultados-table tbody");
    const resultadosSection = document.getElementById("resultados-section");

    // Mostrar spinner
    function showLoading(element) {
        const spinner = document.createElement("div");
        spinner.classList.add("spinner");
        spinner.textContent = "Cargando...";
        element.parentElement.appendChild(spinner);
    }

    // Ocultar spinner
    function hideLoading(element) {
        const spinner = element.parentElement.querySelector(".spinner");
        if (spinner) spinner.remove();
    }

    // Cargar campañas (GET)
    async function loadCampaigns(url, selectElement) {
        try {
            showLoading(selectElement);
            const response = await fetch(url);
            if (!response.ok) throw new Error(`Error al cargar campañas: ${response.statusText}`);
            const data = await response.json();
            console.log("Campañas recibidas:", data);

            // Llenar <select>
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item.campaign_id;
                option.textContent = item.campaign_id;
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error("Error al cargar campañas:", error);
            alert("Error al cargar campañas. Consulte la consola.");
        } finally {
            hideLoading(selectElement);
        }
    }

    // Cargar grupos de usuario (POST)
    async function loadUserGroups(url, selectElement, payload) {
        try {
            showLoading(selectElement);
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(payload),
            });
            if (!response.ok) throw new Error(`Error al cargar grupos: ${response.statusText}`);
            const data = await response.json();
            console.log("Grupos de usuario recibidos:", data);

            // Llenar <select>
            data.forEach(item => {
                const option = document.createElement("option");
                option.value = item.user_group;
                option.textContent = item.user_group;
                selectElement.appendChild(option);
            });
        } catch (error) {
            console.error("Error al cargar grupos:", error);
            alert("Error al cargar grupos. Consulte la consola.");
        } finally {
            hideLoading(selectElement);
        }
    }

    // Cargar campañas y grupos de usuario
    await loadCampaigns("http://192.168.1.6:3000/test/campid", campaignsSelect);
    await loadUserGroups("http://192.168.1.6:3000/cliente/UserGroup", groupsSelect, { someKey: "someValue" });

    // Habilitar botón de descarga si ambos datos están cargados
    downloadBtn.disabled = !(campaignsSelect.options.length > 1 && groupsSelect.options.length > 1);

    // Manejar el evento "ENVIAR"
    enviarBtn.addEventListener("click", async function () {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;
        if (!fechaInicio || !fechaFin) {
            alert("Por favor, seleccione la fecha de inicio y fin.");
            return;
        }

        const campanas = Array.from(campaignsSelect.selectedOptions).map(opt => opt.value);
        const gruposUsuario = Array.from(groupsSelect.selectedOptions).map(opt => opt.value);

        const payload = {
            campaignIds: campanas.includes("all") ? Array.from(campaignsSelect.options).map(opt => opt.value).filter(val => val !== "all") : campanas,
            grupouser: gruposUsuario.includes("all") ? Array.from(groupsSelect.options).map(opt => opt.value).filter(val => val !== "all") : gruposUsuario,
            startDate: `${fechaInicio} 00:00:00`,
            endDate: `${fechaFin} 23:59:59`,
        };

        try {
            const [userTlogData, agentLogData] = await Promise.all([
                fetch("http://192.168.1.6:3000/test/usertlog", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                }).then(response => response.json()),
                fetch("http://192.168.1.6:3000/test/agentlog", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(payload),
                }).then(response => response.json()),
            ]);

            tableBody.innerHTML = "";

            if (userTlogData.message === "No data found" && agentLogData.message === "No data found") {
                resultadosSection.innerHTML = "<p>No se encontraron resultados para la campaña seleccionada.</p>";
                resultadosSection.style.display = "block";
                return;
            }

            const combinedData = userTlogData.map((userItem, index) => ({ ...userItem, ...agentLogData[index] }));

            combinedData.forEach(item => {
                const row = document.createElement("tr");
                Object.values(item).forEach(value => {
                    const td = document.createElement("td");
                    td.textContent = value || "N/A";
                    row.appendChild(td);
                });
                tableBody.appendChild(row);
            });

            resultadosSection.style.display = "block";
        } catch (error) {
            console.error("Error al procesar la información:", error);
            alert("Ocurrió un error al procesar la información.");
        }
    });

    // Manejar el evento "DESCARGAR"
    downloadBtn.addEventListener("click", async function () {
        const fechaInicio = document.getElementById("fechaInicio").value;
        const fechaFin = document.getElementById("fechaFin").value;
        if (!fechaInicio || !fechaFin) {
            alert("Por favor, seleccione la fecha de inicio y fin.");
            return;
        }

        const campanas = Array.from(campaignsSelect.selectedOptions).map(opt => opt.value);
        const gruposUsuario = Array.from(groupsSelect.selectedOptions).map(opt => opt.value);

        const payload = {
            campaignIds: campanas.includes("all") ? Array.from(campaignsSelect.options).map(opt => opt.value).filter(val => val !== "all") : campanas,
            grupouser: gruposUsuario.includes("all") ? Array.from(groupsSelect.options).map(opt => opt.value).filter(val => val !== "all") : gruposUsuario,
            startDate: `${fechaInicio} 00:00:00`,
            endDate: `${fechaFin} 23:59:59`,
        };


        try {
    const response = await fetch("http://192.168.1.6:3000/cliente/generate-report", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
    });

    if (!response.ok) throw new Error("Error al generar el archivo ZIP");

    const blob = await response.blob();
    console.log("Archivo ZIP recibido:", blob);

    // Validar si el archivo es un ZIP válido
    if (blob.size === 0 || blob.type !== "application/zip") {
        throw new Error("El archivo recibido no es un archivo ZIP válido.");
    }

    const arrayBuffer = await blob.arrayBuffer();

    // Importar JSZip
    const JSZip = window.JSZip;

    // Cargar el contenido del ZIP
    const zip = await JSZip.loadAsync(arrayBuffer);
    console.log("Archivo ZIP cargado con éxito:", zip);

    // Verificar si el archivo ZIP contiene archivos
    const fileNames = Object.keys(zip.files);
    if (fileNames.length === 0) {
        throw new Error("El archivo ZIP está vacío.");
    }

    // Buscar el archivo .xlsx dentro del ZIP
    for (const fileName of fileNames) {
        const file = zip.files[fileName];

        if (fileName.endsWith(".xlsx")) { // Verificar si es un archivo Excel
            console.log(`Archivo encontrado: ${fileName}`);

            // Extraer contenido del archivo .xlsx como Blob
            const content = await file.async("blob");

            // Crear enlace para descargar el archivo Excel
            const downloadLink = document.createElement("a");
            downloadLink.href = URL.createObjectURL(content);
            downloadLink.download = fileName; // Nombre del archivo original
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);

            console.log(`Archivo descargado: ${fileName}`);
        } else {
            console.log(`Archivo ignorado: ${fileName}`);
        }
    }
} catch (error) {
    console.error("Error:", error);
    alert("Ocurrió un error al procesar el archivo ZIP.");
}


   });


    document.getElementById('reload-button').addEventListener('click', () => {
      window.location.reload();
  });
});


    </script>

</body>
</html>




@endsection