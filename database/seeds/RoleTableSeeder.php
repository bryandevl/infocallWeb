<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder {
	public function run() {
		Schema::disableForeignKeyConstraints();

		DB::table("roles")->truncate();

		DB::table("roles")
			->insert([
				"id"			=>	1,
				"name"			=>	"SuperAdmin",
				"slug"			=>	"superadmin",
				"description"	=>	"",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("roles")
			->insert([
				"id"			=>	2,
				"name"			=>	"Administrador",
				"slug"			=>	"manager",
				"description"	=>	"",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);
		DB::table("roles")
			->insert([
				"id"			=>	3,
				"name"			=>	"Scoring Manager",
				"slug"			=>	"scoringmanager",
				"description"	=>	"",
				"created_at"	=>	date("Y-m-d H:i:s")
			]);

		Schema::enableForeignKeyConstraints();
	}
}