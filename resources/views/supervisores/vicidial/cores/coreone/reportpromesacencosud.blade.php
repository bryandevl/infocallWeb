@extends('adminlte::page')

@section('htmlheader_title')
Exportar TXT Promesas Cencosud
@endsection
 
@section('contentheader_title')
    Exportar TXT Promesas Cencosud
@endsection

@section('contentheader_description')
    Este informe recoge la información de contactos para las llamadas realizadas en el intervalo de fechas seleccionado. Un contacto solo se exporta una vez sin importar cuántas llamadas fueron realizadas. El estado actual del contacto es usado.
@endsection

@section('main-content')
<div class="container-fluid spark-screen" style="padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="row">
        <div class="col-md-12 text-center">
        </div>
    </div>

    <div class="row" style="margin-top: 20px; width: 100%; display: flex; justify-content: center;">
        <!-- Rango de Fecha -->
        <div class="col-md-3 text-center" style="margin: 0 10px;">
            <label for="start_date"><b>Rango de Fecha:</b></label><br>
            <span>DESDE :</span>
            <input type="date" id="start_date" name="start_date" class="form-control" style="display: inline-block; width: 50%; margin-bottom: 10px;"><br>
            <span>HASTA :</span>
            <input type="date" id="end_date" name="end_date" class="form-control" style="display: inline-block; width: 50%; margin-top: 10px;">
        </div>

        <!-- Campañas -->
        <div class="col-md-3 text-center" style="margin: 0 10px;">
            <label for="campaigns"><b>Campañas:</b></label><br>
            <select id="campaigns" name="campaigns" class="form-control" size="10" style="width: 60%; display: inline-block;">
                <option>---NONE---</option>
            </select>
        </div>

        <!-- Listas -->
        <div class="col-md-3 text-center" style="margin: 0 10px;">
            <label for="lists"><b>Listas:</b></label><br>
            <select id="lists" name="lists" class="form-control" size="10" style="width: 60%; display: inline-block;">
                <option value="">Cargando...</option> <!-- Placeholder mientras se cargan los datos -->
            </select>
        </div>
    </div>

    <!-- Botón Enviar -->
    <div class="row" style="margin-top: 20px; display: flex; justify-content: center; width: 100%;">
        <div class="col-md-12 text-center">
            <button id="download-btn" class="btn btn-primary" disabled>DESCARGAR TXT</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jszip@3.10.1/dist/jszip.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const campaignsSelect = document.getElementById("campaigns");
        const listsSelect = document.getElementById("lists");
        const downloadBtn = document.getElementById("download-btn");

        // Cargar las campañas
        fetch("http://192.168.1.6:3000/test/campid")
            .then(response => {
                console.log("Respuesta de campañas:", response);  // Verifica la respuesta
                return response.json();
            })
            .then(data => {
                console.log("Datos de campañas:", data);  // Verifica los datos recibidos
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

        // Cargar las listas
        fetch("http://192.168.1.6:3000/test/listid")
            .then(response => {
                console.log("Respuesta de listas:", response);  // Verifica la respuesta
                return response.json();
            })
            .then(data => {
                console.log("Datos de listas:", data);  // Verifica los datos recibidos
                data.forEach(item => {
                    const option = document.createElement("option");
                    option.value = item.list_id;
                    option.textContent = item.list_id;
                    listsSelect.appendChild(option);
                });
                // Habilitar el botón de descarga una vez que las listas se han cargado
                downloadBtn.disabled = false;
            })
            .catch(error => {
                console.error("Error al cargar las listas:", error);
            });

        // Evento de clic para descargar el archivo TXT
        downloadBtn.addEventListener("click", function () {
            const startDate = document.getElementById("start_date").value;
            const endDate = document.getElementById("end_date").value;
            const campaigns = Array.from(campaignsSelect.selectedOptions).map(option => option.value);
            const lists = Array.from(listsSelect.selectedOptions).map(option => option.value);

            // Validar los campos
            if (!startDate || !endDate || campaigns.length === 0 || lists.length === 0) {
                alert("Por favor, complete todos los campos.");
                return;
            }

            const requestData = {
                fecha_inicio: `${startDate} 00:00:00`,
                fecha_fin: `${endDate} 23:59:59`,
                campañas: campaigns,
                listid: lists
            };

            // Enviar la solicitud POST
            fetch("http://192.168.1.6:3000/reportesvicidial/promecencosud", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify(requestData)
            })
            .then(response => response.blob()) // Esperar respuesta con el archivo ZIP
            .then(blob => {
                // Verificar que la respuesta sea un archivo ZIP
                if (blob.type !== "application/zip") {
                    console.error("El archivo recibido no es un archivo ZIP:", blob.type);
                    alert("El archivo recibido no es un archivo ZIP.");
                    return;
                }

                // Descomprimir el archivo con JSZip
                const zip = new JSZip();
zip.loadAsync(blob)
    .then(function (zipContent) {
        console.log("Contenido del ZIP:", zipContent);  // Log para depurar
        const txtFile = zipContent.file("report.txt");  // Verifica que el nombre sea correcto
        if (txtFile) {
            txtFile.async("string").then(function (content) {
                // Obtener la fecha actual en formato YYYYMMDD
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');  // Añadir ceros si es necesario
                const day = String(today.getDate()).padStart(2, '0');  // Añadir ceros si es necesario
                const fileDate = `${year}${month}${day}`;  // Formato YYYYMMDD

                const fileName = `EXPORT_LEAD_REPORT_${fileDate}.txt`;  // Nombre del archivo con la fecha

                // Crear un enlace para descargar el archivo TXT extraído
                const link = document.createElement("a");
                const fileBlob = new Blob([content], { type: "text/plain" });
                const url = URL.createObjectURL(fileBlob);
                link.href = url;
                link.download = fileName;  // Usar el nombre generado
                link.click();
                URL.revokeObjectURL(url);
            });
        } else {
            alert("El archivo TXT no se encontró dentro del ZIP.");
        }
    })
    .catch(function (err) {
        console.error("Error al descomprimir el archivo:", err);
        alert("Hubo un error al descomprimir el archivo.");
    });
            })
            .catch(error => {
                console.error("Error al descargar el archivo ZIP:", error);
                alert("Hubo un error al descargar el archivo ZIP.");
            });
        });
    });
    </script>
@endsection
