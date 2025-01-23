<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateMasterTableSeeder extends Seeder {
	public function run() {
		Log::channel("source")
			->info("[ACTUALIZACIÓN DE CAMPOS AUDITORÍA] : ".date("Y-m-d H:i:s"));

		Log::channel("source")
			->info("[TABLA BITEL][START] : ".date("Y-m-d H:i:s"));
		DB::statement("UPDATE bitel SET created_at = validata_created_at, updated_at = validata_updated_at WHERE 1;");
		Log::channel("source")
			->info("[TABLA BITEL][END] : ".date("Y-m-d H:i:s"));

		Log::channel("source")
			->info("[TABLA ENTEL][START] : ".date("Y-m-d H:i:s"));
		DB::statement("UPDATE entel SET created_at = validata_created_at, updated_at = validata_updated_at WHERE 1;");
		Log::channel("source")
			->info("[TABLA ENTEL][END] : ".date("Y-m-d H:i:s"));

		Log::channel("source")
			->info("[TABLA CLARO][START] : ".date("Y-m-d H:i:s"));
		DB::statement("UPDATE claro SET created_at = validata_created_at, updated_at = validata_updated_at WHERE 1;");
		Log::channel("source")
			->info("[TABLA CLARO][END] : ".date("Y-m-d H:i:s"));

		Log::channel("source")
			->info("[TABLA MOVISTAR][START] : ".date("Y-m-d H:i:s"));
		DB::statement("UPDATE movistar SET created_at = validata_created_at, updated_at = validata_updated_at WHERE 1;");
		Log::channel("source")
			->info("[TABLA MOVISTAR][END] : ".date("Y-m-d H:i:s"));

		Log::channel("source")
			->info("[TABLA MOVISTAR FIJO][START] : ".date("Y-m-d H:i:s"));
		DB::statement("UPDATE movistar_fijo SET created_at = validata_created_at, updated_at = validata_updated_at WHERE 1;");
		Log::channel("source")
			->info("[TABLA MOVISTAR FIJO][END] : ".date("Y-m-d H:i:s"));
	}
}