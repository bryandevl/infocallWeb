<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ModuleTableSeeder extends Seeder {
	public function run() {
		DB::table("module")->truncate();

		DB::table("module")
			->insert([
				"id"			=>	1,
				"class_icon"	=>	"fa fa-home",
				"name"			=>	"Inicio",
				"url"			=>	"home"
			]);
		DB::table("module")
			->insert([
				"id"			=>	2,
				"class_icon"	=>	"fa fa-cog",
				"name"			=>	"Accesos",
				"order"			=>	1,
				"num_childs"	=>	3
			]);
		DB::table("module")
			->insert([
				"id"			=>	3,
				"class_icon"	=>	"fa fa-user",
				"name"			=>	"Operadores",
				"order"			=>	2,
				"num_childs"	=>	3
			]);
		DB::table("module")
			->insert([
				"id"			=>	4,
				"class_icon"	=>	"fa fa-list-alt",
				"name"			=>	"Supervisores",
				"order"			=>	3,
				"num_childs"	=>	6
			]);
		DB::table("module")
			->insert([
				"id"			=>	5,
				"class_icon"	=>	"fa fa-key",
				"name"			=>	"SERCH",
				"order"			=>	4,
				"num_childs"	=>	2
			]);
		DB::table("module")
			->insert([
				"id"			=>	6,
				"class_icon"	=>	"fa fa-android",
				"name"			=>	"Validata",
				"order"			=>	5,
				"num_childs"	=>	3,
				"status"		=>	0,
				"visible"		=>	0
			]);
		DB::table("module")
			->insert([
				"id"			=>	7,
				"class_icon"	=>	"fa fa-bar-chart-o",
				"name"			=>	"Scoring",
				"order"			=>	6,
				"num_childs"	=>	4
			]);


		DB::table("module")
			->insert([
				[
					"name"				=>	"Usuarios",
					"order"				=>	7,
					"url"				=>	"master.user.index",
					"module_parent_id"	=>	2
				],
				[
					"name"				=>	"Módulos",
					"order"				=>	8,
					"url"				=>	"master.module.index",
					"module_parent_id"	=>	2
				],
				[
					"name"				=>	"Roles",
					"order"				=>	9,
					"url"				=>	"master.roles.index",
					"module_parent_id"	=>	2
				],
				[
					"name"				=>	"Últimos Accesos",
					"order"				=>	10,
					"url"				=>	"master.user.access.index",
					"module_parent_id"	=>	2
				]
			]);

		DB::table("module")
			->insert([
				[
					"name"				=>	"Cuenta DNI",
					"order"				=>	11,
					"url"				=>	"cuenta_index",
					"module_parent_id"	=>	3
				],
				[
					"name"				=>	"Convertir Voz a Texto",
					"order"				=>	12,
					"url"				=>	"operador.convertir_voz_texto.index",
					"module_parent_id"	=>	3
				],
				[
					"name"				=>	"Carga Números Whatsapp",
					"order"				=>	13,
					"url"				=>	"operador.upload_phone_whatsapp.index",
					"module_parent_id"	=>	3
				]
			]);

		DB::table("module")
			->insert([
				[
					"name"			=>	"Cruce por DNI",
					"order"			=>	14,
					"url"			=>	"supervisores_cruces_dni_create",
					"module_parent_id"	=>	4
				],
				[
					"name"			=>	"Cruce por Operadoras",
					"order"			=>	15,
					"url"			=>	"supervisores_cruces_operadora_create",
					"module_parent_id"	=>	4
				],
				[
					"name"			=>	"Cruce Reniec",
					"order"			=>	16,
					"url"			=>	"supervisores_cruces_reniec_create",
					"module_parent_id"	=>	4
				],
				[
					"name"			=>	"Essalud",
					"order"			=>	17,
					"url"			=>	"supervisores_cruces_essalud_create",
					"module_parent_id"	=>	4
				],
				[
					"name"			=>	"Correo",
					"order"			=>	18,
					"url"			=>	'supervisor.gestion.transferencia.index',
					"module_parent_id"	=>	4
				],
				[
					"name"			=>	"Gestión de Transferencias",
					"order"			=>	19,
					"url"			=>	"supervisor.gestion.transferencia.index",
					"module_parent_id"	=>	4
				],

				[
					"name"			=>	"Reportes Vicidial",
					"order"			=>	20,
					"url"			=>	"supervisores.vicidial.cores.index",
					"module_parent_id"	=>	4
				]


			]);

		DB::table("module")
			->insert([
				[
					"name"				=>	"Búsqueda DNI",
					"order"				=>	20,
					"url"				=>	"serch_dni_index",
					"module_parent_id"	=>	5
				],
				[
					"name"				=>	"Log SERCH",
					"order"				=>	21,
					"url"				=>	"serch_log_index",
					"module_parent_id"	=>	5
				]
			]);

		DB::table("module")
			->insert([
				[
					"name"				=>	"Búsqueda Validata",
					"order"				=>	22,
					"url"				=>	"validata.search.index",
					"module_parent_id"	=>	6,
					"status"			=>	0
				],
				[
					"name"				=>	"Log Validata",
					"order"				=>	23,
					"url"				=>	"validata_log_index",
					"module_parent_id"	=>	6,
					"status"			=>	0
				],
				[
					"name"				=>	"Reporte SBS",
					"order"				=>	24,
					"url"				=>	"validata_reporte_sbs_index",
					"module_parent_id"	=>	6,
					"status"			=>	0
				]
			]);

		DB::table("module")
			->insert([
				[
					"name"			=>	"Nuevo Período",
					"order"			=>	25,
					"url"			=>	"scoring_new_period",
					"module_parent_id"	=>	7
				],
				[
					"name"			=>	"Histórico de Periodos",
					"order"			=>	26,
					"url"			=>	"scoring_historic",
					"module_parent_id"	=>	7
				],
				[
					"name"			=>	"Configurar Filtros",
					"order"			=>	27,
					"url"			=>	"scoring_settings",
					"module_parent_id"	=>	7
				],
				[
					"name"			=>	"Resumen",
					"order"			=>	28,
					"url"			=>	"scoring_match",
					"module_parent_id"	=>	7
				]
			]);

	}
}