@extends('adminlte::page')

@section('htmlheader_title')
Reporte Speech Analytics
@endsection

@section('contentheader_title')
Reporte Speech Analytics
@endsection

@section('contentheader_description')
    Este informe recoge la información de contactos para las llamadas realizadas en la fecha seleccionada. Un contacto solo se exporta una vez sin importar cuántas llamadas fueron realizadas. El estado actual del contacto es usado.
@endsection

@section('main-content')
<div class="container-fluid spark-screen" style="padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
    <div class="row">
        <div class="col-md-12 text-center">
            <h3>Filtrar Reporte</h3>
        </div>
    </div>

    <div class="row" style="margin-top: 20px; width: 100%; display: flex; justify-content: center;">
        <!-- Fecha -->
        <div class="col-md-4 text-center" style="margin: 0 10px;">
            <label for="date"><b>FECHA:</b></label><br>
            <input type="date" id="date" name="date" class="form-control" style="display: inline-block; width: 50%; margin-bottom: 10px;">
        </div>

        <!-- Campañas -->
        <div class="col-md-4 text-center" style="margin: 0 10px;">
            <label for="campaigns"><b>Campañas:</b></label><br>
            <select id="campaigns" name="campaigns[]" class="form-control" size="10" multiple style="width: 50%; display: inline-block;">
                <option value="" disabled>--- Seleccionar ---</option>
            </select>
            <div id="error-msg" style="color: red; margin-top: 10px; display: none;">No se pudieron cargar las campañas.</div>
        </div>
    </div>

    <!-- Botón Enviar -->
    <div class="row" style="margin-top: 20px; display: flex; justify-content: center; width: 100%;">
        <div class="col-md-12 text-center">
            <button id="submit-btn" class="btn btn-primary" disabled>ENVIAR REPORTE</button>
        </div>
    </div>

    <!-- Barra de carga -->
    <div id="progress-container" class="row" style="margin-top: 20px; display: none; justify-content: center; width: 100%;">
        <div class="col-md-8">
            <div class="progress">
                <div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <span id="progress-text" style="color: white; font-weight: bold;">0%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensaje de respuesta -->
    <div id="response-message" class="row" style="margin-top: 20px; display: none; justify-content: center; width: 100%;">
        <div class="col-md-8 text-center">
            <div class="alert" id="response-alert"></div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById("date");
    const campaignsSelect = document.getElementById("campaigns");
    const submitBtn = document.getElementById("submit-btn");
    const errorMsg = document.getElementById("error-msg");
    const progressBar = document.getElementById("progress-bar");
    const progressText = document.getElementById("progress-text");
    const progressContainer = document.getElementById("progress-container");
    const responseMessage = document.getElementById("response-message");
    const responseAlert = document.getElementById("response-alert");

    // Cargar las campañas
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
            errorMsg.style.display = "none";
        })
        .catch(error => {
            console.error("Error al cargar las campañas:", error);
            errorMsg.style.display = "block";
            errorMsg.textContent = "Error al cargar campañas. Intente nuevamente.";
        });

    // Validar que ambos campos estén completos para habilitar el botón
    const validateForm = () => {
        const dateSelected = dateInput.value;
        const campaignsSelected = [...campaignsSelect.options].some(option => option.selected);
        submitBtn.disabled = !(dateSelected && campaignsSelected);
    };

    dateInput.addEventListener("change", validateForm);
    campaignsSelect.addEventListener("change", validateForm);

    // Manejar la barra de progreso
    const updateProgress = (percentage) => {
        progressBar.style.width = `${percentage}%`;
        progressBar.setAttribute("aria-valuenow", percentage);
        progressText.textContent = `${percentage}%`;
    };

    // Enviar la solicitud
    submitBtn.addEventListener("click", () => {
        const date = dateInput.value;
        const campaigns = [...campaignsSelect.selectedOptions].map(option => option.value);

        const payload = {
            startDate: `${date} 00:00:00`,
            endDate: `${date} 23:59:59`,
            campaigns
        };

        // Mostrar barra de progreso
        progressContainer.style.display = "block";
        updateProgress(0);

        // Simular progreso inicial hasta 50%
        let progress = 0;
        const interval = setInterval(() => {
            if (progress < 50) {
                progress += 5;
                updateProgress(progress);
            } else {
                clearInterval(interval);
            }
        }, 200); // Incremento de progreso cada 200ms

        // Enviar solicitud al servidor
        fetch("http://192.168.1.6:3000/test/generate-excel", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json())
        .then(data => {
            // Completar progreso al 100% una vez que se reciba la respuesta
            updateProgress(100);

            // Mostrar mensaje de éxito
            responseMessage.style.display = "flex";
            responseAlert.className = "alert alert-success";
            responseAlert.textContent = data.message;

            // Ocultar barra de progreso después de un tiempo
            setTimeout(() => {
                progressContainer.style.display = "none";
            }, 2000);
        })
        .catch(error => {
            console.error("Error al procesar el reporte:", error);

            // Mostrar mensaje de error
            responseMessage.style.display = "flex";
            responseAlert.className = "alert alert-danger";
            responseAlert.textContent = "Ocurrió un error al procesar el reporte. Intente nuevamente.";

            // Ocultar barra de progreso
            progressContainer.style.display = "none";
        });
    });
});
</script>
@endsection
