<?php

return [
	"api" => [
		"endpoint" => [
			"local" => "https://tu-api.com/datos?key=tkhztznqev8e4g3hed8dkj4tr2u6d7",
			"production" => "https://tu-api.com/datos?key=tkhztznqev8e4g3hed8dkj4tr2u6d7"
		],
		"endpoint_empresa" => [
			"local" => "https://www.tu-api.com/datos_e?key=tkhztznqev8e4g3hed8dkj4tr2u6d7",
			"production" => "https://www.tu-api.com/datos_e?key=tkhztznqev8e4g3hed8dkj4tr2u6d7"
		],
		"versionEssalud"	=>	env("APP_VERSION_ESSALUD_VALIDATA", 0)
	],
	"keycache" => [
		"validata_code" => env("APP_SYSTEM", "")."_validata_code_cache",
		"source_code" => env("APP_SYSTEM", "")."_validata_source_code_cache"
	]
];
