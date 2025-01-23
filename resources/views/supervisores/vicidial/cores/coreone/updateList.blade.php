@extends('adminlte::page')

@section('htmlheader_title')
    Actualizar CRDIAL
@endsection

@section('contentheader_title')
    <i class="fa fa-id-card-o"></i> Supervisores
@endsection

@section('contentheader_description')
    Actualizar CRDIAL
@endsection

@section('contentheader_breadcrumb')
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Supervisores</li>
    </ol>
@endsection

@section('main-content')

<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <style type="text/tailwindcss">
      @layer base {
        :root {
          --background: 0 0% 100%;
          --foreground: 240 10% 3.9%;
        }
      }
    </style>
  </head>
  <body>
    <div class="max-w-5xl mx-auto p-8 bg-card rounded-lg shadow-md">
      <h2 class="text-2xl font-semibold text-foreground mb-6">Actualizar LISTA desde Archivo:</h2>
      
      <form id="update-form" action="http://192.168.1.6:3000/vicidial-list/update" method="POST" enctype="multipart/form-data">
        <label class="block mb-4 text-muted-foreground" for="file-upload">Seleccionar archivo:</label>
        <input type="file" id="file-upload" name="file" class="block w-full p-3 border border-border rounded-md mb-6"  accept=".xls,.xlsx,.csv"  required />
        
        <label class="block mb-4 text-muted-foreground" for="campaign-select">Seleccionar Campaña:</label>
        <select id="campaign-select" name="list_id" class="text-2xl block w-full p-3 border border-border rounded-md mb-6" required>
            <option value="" disabled selected>Seleccionar Campaña</option>
        </select>

        <!-- Contenedor para mensajes de estado -->
        <div id="status-message" class="hidden p-4 mb-4 text-white bg-primary rounded-md" aria-live="polite"></div>
        <!-- Contenedor para mostrar la respuesta -->
        <div id="response-container" class="hidden p-4 mb-4 bg-green-100 text-green-800 rounded-md" aria-live="polite"></div>

        <div class="flex flex-wrap justify-between gap-4">
            <button type="submit" class="bg-primary text-primary-foreground hover:bg-primary/80 p-3 rounded-md">ENVIAR</button>
            <button id="reload-button" type="button" class="bg-secondary text-secondary-foreground hover:bg-secondary/80 p-3 rounded-md">
    Volver a iniciar
</button>
        </div>
      </form>
    </div>

    <script>
      document.addEventListener('DOMContentLoaded', () => {
        const statusMessage = document.getElementById('status-message');
        const responseContainer = document.getElementById('response-container');

        // Función para manejar la visualización de mensajes
        function showMessage(container, message, type = 'info') {
          container.classList.remove('hidden', 'bg-blue-500', 'bg-green-500', 'bg-red-500');
          container.classList.add(type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500');
          container.textContent = message;
        }

        // Función para manejar la carga de campañas
        async function loadCampaigns() {
          try {
            const response = await fetch('http://192.168.1.6:3000/cliente/VI_LISTS', { method: 'POST' });

            if (!response.ok) throw new Error(`Error al cargar campañas: ${response.status}`);

            const data = await response.json();
            const campaignSelect = document.getElementById('campaign-select');
            data.forEach(item => {
              const option = document.createElement('option');
              option.value = item.list_id;
              option.textContent = item.name;
              campaignSelect.appendChild(option);
            });
          } catch (error) {

            console.error('Error al cargar campañas:', error);
            showMessage(statusMessage, '❌ Error al cargar campañas. Intente nuevamente.', 'error');

          }
        }

        // Función para manejar el envío del formulario
        async function submitForm(event) {
          event.preventDefault(); // Previene el comportamiento predeterminado del formulario

          const fileInput = document.getElementById('file-upload');
          const campaignSelect = document.getElementById('campaign-select');

          // Mostrar mensaje de estado inicial
          showMessage(statusMessage, 'Enviando datos...', 'info');
          responseContainer.classList.add('hidden');

          const file = fileInput.files[0];
          const listId = campaignSelect.value;

          if (!file || !listId) {
            showMessage(statusMessage, '❌ Por favor, seleccione un archivo y una campaña.', 'error');
            return;
          }

          const formData = new FormData();
          formData.append('list_id', listId);
          formData.append('file', file);

          try {
            const response = await fetch('http://192.168.1.6:3000/vicidial-list/update', {
              method: 'POST',
              body: formData,
            });

            if (response.ok) {
              const result = await response.json();
              showMessage(statusMessage, `✅ ${result.message}`, 'success');
              responseContainer.innerHTML = `
                <p><strong>Mensaje:</strong> ${result.message}</p>
                <p><strong>Registros actualizados:</strong> ${result.updatedRecords}</p>
              `;
              responseContainer.classList.remove('hidden');
            } else {
              const errorResponse = await response.json();
              throw new Error(errorResponse.message || 'Error al actualizar la lista.');
            }
          } catch (error) {
            showMessage(statusMessage, `❌ Error: ${error.message}`, 'error');
          }
        }

        // Agregar listener al formulario
        document.getElementById('update-form').addEventListener('submit', submitForm);
        document.getElementById('reload-button').addEventListener('click', () => {
      window.location.reload();
  });
  
  document.getElementById('file-upload').addEventListener('change', (event) => {
    const file = event.target.files[0];
    const allowedExtensions = ['xls', 'xlsx', 'csv'];

    if (file) {
      const fileExtension = file.name.split('.').pop().toLowerCase();
      if (!allowedExtensions.includes(fileExtension)) {
        alert('Solo se permiten archivos con formato .xls, .xlsx o .csv');
        event.target.value = ''; // Limpiar el campo
      }
    }
  });
        // Cargar campañas al iniciar
        loadCampaigns();
      });



    </script>
  </body>
</html>

@endsection
