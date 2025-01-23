<?php namespace App\Serch\Helpers;

class SerchApiHelper
{
	public static function getApiUrl($endpoint = "", $document = "")
	{
		$enviroment = env("APP_ENV", "");
		if ($enviroment == "testing") {
			$enviroment = "local";
		}
		$userApi = \Config::get("serch.api.credentials.{$enviroment}.user");
		$passwordApi = \Config::get("serch.api.credentials.{$enviroment}.password");

		$pathUrl = $endpoint."?user=".$userApi."&password=".$passwordApi."&documento=".$document;
		$result = file_get_contents($pathUrl);
		return json_decode($result, true);
	}
}