<?php

return [
	"assets" => [
		"js"	=>	"20231203140300"
	],
	"roles"	=>	[
		"fullaccess" => [
			"superadmin",
			"manager"
		]
	],
	"letters" => [
		"puntuaction_marks"	=>	[".", ",", ";", ":", "'", '"', "(", ")", "¡", "!", "¿", "?", "-", "_"]
	],
	"endpoint" => [
		"scoring"	=>	env("SCORING_ENDPOINT", "http://127.0.0.1:3000")
	]
];