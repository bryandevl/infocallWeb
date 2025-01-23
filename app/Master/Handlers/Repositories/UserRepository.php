<?php namespace App\Master\Handlers\Repositories;

use App\Master\Handlers\UserInterface;
use App\Configuration\Models\ConfigUser;

class UserRepository implements UserInterface
{
	protected $_keyCache;

	public function __construct()
	{
		$this->_keyCache = \Config::get("configuration.keycache.user");
	}
	public function getConfigUserCache()
	{
		$configUserList = \Cache::get($this->_keyCache);
        if (!$configUserList) {
            $configUserList = \Cache::remember(
                $this->_keyCache,
                24*60*60,
                function () {
                    return ConfigUser::where("status", 1)->get()->toArray();
                }
            );
        }
        return $configUserList;
	}
	public function getConfigUserByKey($key)
	{
		$configUser = $this->getConfigUserCache();

		foreach ($configUser as $key2 => $value2) {
			if ($value2["key"] == $key) {
				switch((int)$value2["type"]) {
					case 1:
						return $value2["value"];
						break;
					case 3:
						$jsonValues = json_decode($value2["value"], true);
						foreach($jsonValues as $key3 => $value3) {
							if ($value3["selected"]) {
								return $value3["id"];
							}
						}
						break;
					default:
						break;
				}
			}
		}
	}

	public function validateRulesPassword($password = "") {
		$configUsers = $this->getConfigUserCache();

		foreach($configUsers as $key => $value) {
			switch($value["key"]) {
				case "password_size_min":
					$min = (int)$value["value"];
					if (strlen($password) < $min) {
						return [
							"rst" => 2,
							"msj" => "No cumple el tamaño mínimo para la contraseña ({$min})"
						];
					}
					break;
				case "password_size_max":
					$max = (int)$value["value"];
					if (strlen($password) > $max) {
						return [
							"rst" => 2,
							"msj" => "No cumple el tamaño máximo para la contraseña ({$max})"
						];
					}
					break;
				case "password_min_letter_upper":
					$minLetter = (int)$value["value"];
					$existsUpperLetter = 0;
					$chars = str_split($password);
					foreach($chars as $key => $value) {
						if (ctype_upper($value)) {
							$existsUpperLetter++;
						}
					}
					if ($existsUpperLetter < $minLetter) {
						return [
							"rst" => 2,
							"msj" => "No cumple el mínimo de mayúsculas para la contraseña ({$minLetter})"
						];
					}
					break;
				case "password_min_letter_lower":
					$minLetter = (int)$value["value"];
					$existsLowerLetter = 0;
					$chars = str_split($password);
					foreach($chars as $key => $value) {
						if (ctype_lower($value)) {
							$existsLowerLetter++;
						}
					}
					if ($existsLowerLetter < $minLetter) {
						return [
							"rst" => 2,
							"msj" => "No cumple el mínimo de minísculas para la contraseña ({$minLetter})"
						];
					}
					break;
				case "password_min_puntuaction_marks":
					$minLetter = (int)$value["value"];
					$exitsLetter = 0;
					$chars = str_split($password);
					foreach($chars as $key => $value) {
						if (in_array($value, config("crreportes.letters.puntuaction_marks"))) {
							$exitsLetter++;
						}
					}
					if ($exitsLetter < $minLetter) {
						return [
							"rst" => 2,
							"msj" => "La contraseña debe tener por lo menos ({$minLetter}) signo de puntuación"
						];
					}
					break;
				default:
					break;
			}
		}
		return ["rst" => 1];
	}
}