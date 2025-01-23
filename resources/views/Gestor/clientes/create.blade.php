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
    <li><a href="{{ route('Gestor.clientes.index') }}">BUSCAR CLIENTES</a></li> 
</ol>
@endsection

@section('main-content')
<html>
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
		<script src="https://unpkg.com/unlazy@0.11.3/dist/unlazy.with-hashing.iife.js" defer init></script>
		<script type="text/javascript">
			window.tailwind.config = {
				darkMode: ['class'],
				theme: {
					extend: {
						colors: {
							border: 'hsl(var(--border))',
							input: 'hsl(var(--input))',
							ring: 'hsl(var(--ring))',
							background: 'hsl(var(--background))',
							foreground: 'hsl(var(--foreground))',
							primary: {
								DEFAULT: 'hsl(var(--primary))',
								foreground: 'hsl(var(--primary-foreground))'
							},
							secondary: {
								DEFAULT: 'hsl(var(--secondary))',
								foreground: 'hsl(var(--secondary-foreground))'
							},
							destructive: {
								DEFAULT: 'hsl(var(--destructive))',
								foreground: 'hsl(var(--destructive-foreground))'
							},
							muted: {
								DEFAULT: 'hsl(var(--muted))',
								foreground: 'hsl(var(--muted-foreground))'
							},
							accent: {
								DEFAULT: 'hsl(var(--accent))',
								foreground: 'hsl(var(--accent-foreground))'
							},
							popover: {
								DEFAULT: 'hsl(var(--popover))',
								foreground: 'hsl(var(--popover-foreground))'
							},
							card: {
								DEFAULT: 'hsl(var(--card))',
								foreground: 'hsl(var(--card-foreground))'
							},
						},
					}
				}
			}
		</script>
		<style type="text/tailwindcss">
			@layer base {
				:root {
					--background: 0 0% 100%;
--foreground: 240 10% 3.9%;
--card: 0 0% 100%;
--card-foreground: 240 10% 3.9%;
--popover: 0 0% 100%;
--popover-foreground: 240 10% 3.9%;
--primary: 240 5.9% 10%;
--primary-foreground: 0 0% 98%;
--secondary: 240 4.8% 95.9%;
--secondary-foreground: 240 5.9% 10%;
--muted: 240 4.8% 95.9%;
--muted-foreground: 240 3.8% 46.1%;
--accent: 240 4.8% 95.9%;
--accent-foreground: 240 5.9% 10%;
--destructive: 0 84.2% 60.2%;
--destructive-foreground: 0 0% 98%;
--border: 240 5.9% 90%;
--input: 240 5.9% 90%;
--ring: 240 5.9% 10%;
--radius: 0.5rem;
				}
				.dark {
					--background: 240 10% 3.9%;
--foreground: 0 0% 98%;
--card: 240 10% 3.9%;
--card-foreground: 0 0% 98%;
--popover: 240 10% 3.9%;
--popover-foreground: 0 0% 98%;
--primary: 0 0% 98%;
--primary-foreground: 240 5.9% 10%;
--secondary: 240 3.7% 15.9%;
--secondary-foreground: 0 0% 98%;
--muted: 240 3.7% 15.9%;
--muted-foreground: 240 5% 64.9%;
--accent: 240 3.7% 15.9%;
--accent-foreground: 0 0% 98%;
--destructive: 0 62.8% 30.6%;
--destructive-foreground: 0 0% 98%;
--border: 240 3.7% 15.9%;
--input: 240 3.7% 15.9%;
--ring: 240 4.9% 83.9%;
				}
			}
		</style>
  </head>
  <body>
    <div class="bg-background p-8 rounded-lg shadow-lg max-w-2xl mx-auto">
        <h1 class="text-center text-4xl font-bold mb-6">BUSCAR CLIENTES</h1>
        <div>
            <h2 id="campaign-title" class="text-3xl mb-8"></h2>
        </div>

        <label class="block mb-4 text-2xl font-semibold text-muted-foreground">
            Documento de Identidad (DNI / RUC):
        </label>
        <input id="dni-input" type="number" require class="border border-zinc-300 p-4 rounded-lg w-full mb-6 text-lg" placeholder="Ingrese su DNI/RUC" />

        <label class="block mb-4 text-2xl font-semibold text-muted-foreground">
            Número de cuenta:
        </label>
        <input id="account-input" type="number" class="border border-zinc-300 p-4 rounded-lg w-full mb-6 text-lg" placeholder="Ingrese su número de cuenta" />

        <button id="consultar-button" type="button" class="text-primary-foreground hover:bg-primary/80 p-4 rounded-lg w-full text-xl font-bold" style="background-color:#3C8DBC">
            Consultar Cliente
        </button>
    </div>

</body>
</html>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const campaignTitleElement = document.getElementById("campaign-title");
        const campaignId = localStorage.getItem("campaign_id"); // Recupera el ID de la campaña
        const campaignName = localStorage.getItem("campaign_name"); // Recupera el nombre de la campaña

        if (campaignId && campaignName) {
            // Muestra el nombre de la campaña y el ID
            campaignTitleElement.innerHTML = `Bienvenido a la campaña: <strong>${campaignId}</strong>`;
        } else {
            // Opcional: muestra un mensaje si no hay datos almacenados
            campaignTitleElement.textContent = `Bienvenido a la campaña "Sin seleccionar"`;
        }

    	// Referencias a los elementos del formulario
        const dniInput = document.getElementById("dni-input");
        const accountInput = document.getElementById("account-input");
        const submitButton = document.getElementById("consultar-button");

        // Maneja el clic del botón "Consultar Cliente"
        submitButton.addEventListener("click", (event) => {
            event.preventDefault(); // Evita la acción predeterminada del botón

            const dni = dniInput.value.trim();
            const accountNumber = accountInput.value.trim();

            // Valida que se haya ingresado un DNI
            if (!dni) {
                alert("Por favor, ingrese un DNI.");
                dniInput.focus();
                return; // Detiene la ejecución si el DNI está vacío
            }

            // Almacena DNI y campaign_id en localStorage
            localStorage.setItem("dni", dni);
            localStorage.setItem("campania", campaignId);

            // Si el número de cuenta no está vacío, también lo almacena
            if (accountNumber) {
                localStorage.setItem("num_cta", accountNumber);
            } else {
                localStorage.removeItem("num_cta"); // Asegura que no quede un valor antiguo
            }

            // Redirige al siguiente paso
            window.location.href = "{{ route('Gestor.clientes.show') }}";
        });
    });
</script>
@endsection