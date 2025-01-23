<?php

return [
	"convertir_voz_a_texto" => [
		"path_audios" => env("APP_PATH_UPLOAD_VOICE", "/var/www/html/crreportes/public/audios/"),
		"translate_to_text" => "/var/www/html/crreportes/scripts/voice/voice_convert_test01.py"
	],
	"upload_phone_whatsapp"	=>	[
		"path_csv" => env("APP_PATH_UPLOAD_CSV", "/var/www/html/crreportes/storage/whatsapp/")
	]
];