<?php

Route::get("test-python", function() {
	$script = "sudo ".env("APP_PATH_PYTHON")." ".env("APP_SCRIPT_TRANSLATE")." /var/www/html/crreportes/public/audios/miamor01.wav 2>&1";
	echo $script;
	$command = escapeshellcmd($script);
    $output = shell_exec($command);
    echo $output;
});