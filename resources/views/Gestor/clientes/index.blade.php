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
<div class="container spark-screen" style="max-width: 400px; margin: 0 auto; text-align: center; min-height: 20vh; display: flex; flex-direction: column; justify-content: center;">
    <h1 class="text-center">Ver Clientes</h1>
    <!-- Ver Clientes - list -->
    <div class="box box-primary" style="display: inline-block;">
        <div class="box-header with-border">
            <h3 class="box-title">Seleccionar Campañas</h3>
        </div>
        <div class="box-body">
            <!-- Lista de campañas -->
            <ul id="campaignList" class="list-group" style="list-style-type: none; padding: 0; text-align: center;">
                <li id="campaignItem">Cargando campañas...</li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const apiUrl = "http://192.168.2.72:5001/maestra/campaings";
        const campaignList = document.getElementById("campaignList");

        async function loadCampaigns() {
            try {
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    credentials: 'include',
                });

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log("Datos recibidos:", data);

                campaignList.innerHTML = "";

                if (Array.isArray(data) && data.length > 0) {
                    data.forEach(campaign => {
                        const listItem = document.createElement("li");
                        listItem.className = "list-group-item";
                        listItem.style.margin = "1px auto";

                        const link = document.createElement("a");
                        link.textContent = `${campaign.campaign_name}`;
                        // Aquí generamos dinámicamente el enlace de Laravel sin especificar la URL
                        link.href = `{{ route('Gestor.clientes.create') }}`; // Ruta estática sin parámetros
                        link.style.textDecoration = "none";
                        link.style.color = "#007BFF"; // Color del enlace
                        link.addEventListener("click", () => {
                         localStorage.setItem("campaign_id", campaign.campaign_id); // Guarda el ID en localStorage
                         localStorage.setItem("campaign_name", campaign.campaign_name); // Guarda el nombre en localStorage
                            });
                        listItem.appendChild(link);
                        campaignList.appendChild(listItem);
                    });
                } else {
                    campaignList.innerHTML = "<li>No hay campañas disponibles</li>";
                }
            } catch (error) {
                console.error("Error al cargar campañas:", error);
                campaignList.innerHTML = `<li>Error al cargar campañas: ${error.message}</li>`;
            }
        }

        loadCampaigns();
    });
</script>
@endsection

