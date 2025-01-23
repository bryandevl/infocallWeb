<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ConfigUserTableSeeder extends Seeder {
	public function run() {
		Schema::disableForeignKeyConstraints();

		DB::table("config_user")->truncate();

		$twoDecisionArray = [
			[
				"id"	=>	0,
				"name"	=>	"SI",
				"selected"	=>	true
			],
			[
				"id"	=>	1,
				"name"	=>	"NO",
				"selected"	=>	false
			],
		];
		DB::table("config_user")
			->insert([
				"name"			=>	"Evitar que el usuario cambie contraseña",
				"key"			=>	"change_password_by_user",
				"value"			=>	json_encode($twoDecisionArray),
				"type"			=>	3,
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Tamaño mínimo de la contraseña",
				"key"			=>	"password_size_min",
				"value"			=>	8,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Tamaño máximo de la contraseña",
				"key"			=>	"password_size_max",
				"value"			=>	64,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Mínimo de caracteres en mayúsculas",
				"key"			=>	"password_min_letter_upper",
				"value"			=>	1,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Mínimo de caracteres en minúsculas",
				"key"			=>	"password_min_letter_lower",
				"value"			=>	1,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Mínimo de signos de puntuación",
				"key"			=>	"password_min_puntuaction_marks",
				"value"			=>	1,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Mínimo de caracteres numéricos",
				"key"			=>	"password_min_letter_numeric",
				"value"			=>	1,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Antiguedad Mínima de la Contraseña (días)",
				"key"			=>	"password_min_days_expired",
				"value"			=>	60,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Antiguedad Máxima de la Contraseña (días)",
				"key"			=>	"password_max_days_expired",
				"value"			=>	90,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Máximo número de intentos de loguear",
				"key"			=>	"quantity_login_attempts",
				"value"			=>	6,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("config_user")
			->insert([
				"name"			=>	"Tiempo de Bloqueo en Minutos",
				"key"			=>	"blocked_login_minutes",
				"value"			=>	60,
				"type"			=>	1,
				"type_input"	=>	"number",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);

		Schema::enableForeignKeyConstraints();
		\Cache::forget(\Config::get("configuration.keycache.user"));
	}
}