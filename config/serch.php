<?php

return [
	"api" => [
		"endpoint" => [
			"local" => [
				"people_info" => "http://5.199.171.68/api/datos_personales",
				"essalud_info" => "http://5.199.171.68/api/datos_essalud",
				"sbs_info" => "http://5.199.171.68/api/datos_sbs",
				"phone_info" => "http://5.199.171.68/api/datos_telefonos",
				"email_info" => "http://5.199.171.68/api/datos_correos",
				"familiar_info" => "http://5.199.171.68/api/datos_familia",
			],
			"production" => [
				"people_info" => "http://5.199.171.68/api/datos_personales",
				"essalud_info" => "http://5.199.171.68/api/datos_essalud",
				"sbs_info" => "http://5.199.171.68/api/datos_sbs",
				"phone_info" => "http://5.199.171.68/api/datos_telefonos",
				"email_info" => "http://5.199.171.68/api/datos_correos",
				"familiar_info" => "http://5.199.171.68/api/datos_familia",
			]
		],
		"credentials" => [
			"local" => [
				"user" => "api_search",
				"password" => 'zHtdVZZn3RFt'
			],
			"production" => [
				"user" => "api_search",
				"password" => 'zHtdVZZn3RFt'
			]
		]
	],
	"operadores" => ["MOVISTAR", "CLARO", "ENTEL", "BITEL"],
	"tipos_telefono" => ["CELULAR", "FIJO"],
	"tipos_familiar" => ["HERMANO", "CONYUGUE", "HIJO", "CONCUBINO", "OTRO"],
	"keycache" => [
		"listPersona" => env("APP_SYSTEM", "")."_listPersona",
		"serch_code" => env("APP_SYSTEM", "")."_serch_code_cache",
		"source_code" => env("APP_SYSTEM", "")."_source_code_cache"
	]
];
