<?php namespace App\Auth\Handlers\Repository;

use App\Auth\Handlers\LoginInterface;
use App\User;
use App\Helpers\InlineEmail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class LoginRepository implements LoginInterface
{
	public function getByEmail($auth = [])
	{
		$objAuth = null;
		if (isset($auth["email"])) {
			$objAuth = User::where("email", $auth["email"])->first();
		}
		return $objAuth;
	}

	public function getByUsername($auth = [])
	{
		$objAuth = null;
		if (isset($auth["user_name"])) {
			$objAuth = User::where("user_name", $auth["user_name"])->first();
		}
		return $objAuth;
	}

	public function validateRecaptchaDos($captcha = [])
	{
		$url = env("URL_VALIDATE_RECAPTCHA_V2", "");
        $data = [
            "secret" => env("RECAPTCHA_V2_KEY_PRIVATE", ""),
            "response" => $captcha["g-recaptcha-response"]
        ];
        $options = [
            "http" => [
                "method" => 'POST',
                "content" => http_build_query($data),
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            ]
        ];
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        return json_decode($verify, true);
	}

	public function validateRecaptchaTres($captcha = [])
	{
		$url = env("URL_VALIDATE_RECAPTCHA_V2", "");
        $data = [
            "secret" => env("RECAPTCHA_V3_KEY_PRIVATE", ""),
            "response" => $captcha["token"]
        ];
        $options = [
            "http" => [
                "method" => 'POST',
                "content" => http_build_query($data),
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
            ]
        ];
        $context  = stream_context_create($options);
        $verify = file_get_contents($url, false, $context);
        return json_decode($verify, true);
	}

	public function getPasswordReset($email = "", $timeExpire = 60)
	{
		$passwordReset = \Cache::get(\Config::get("keycache.auth.password.reset").$email);
		if (!$passwordReset) {
			$passwordReset = \Cache::remember(
                \Config::get("keycache.auth.password.reset").$email,
                1*60*$timeExpire,
                function() use ($email, $timeExpire) {
                    return DB::table("password_resets")
					->where("email", $email)
					->whereRaw("TIMESTAMPDIFF(MINUTE, created_at, '".date('Y-m-d h:i:s')."') <= ".$timeExpire)
					->first();
                }
            );
		}
		return $passwordReset;
	}

	public function setPasswordReset($email = "")
	{
		$hashRandom = Str::random(60);
		DB::table('password_resets')->insert([
		    'email' => $email,
		    'token' => $hashRandom,
		    'created_at' => Carbon::now()
		]);
		\Cache::forget( \Config::get("keycache.auth.password.reset").$email);
	}

	public function sendEmailPasswordRecovery($user = null)
	{
		$data = [
			"user" => null,
			"token" => ""
		];
		if (!is_null($user)) {
			$token = $this->getPasswordReset($user->email);
			if (!is_null($token)) {
				$data["token"] = $token->token;
			} else {
				$this->setPasswordReset($user->email);
				$tmp = $this->getPasswordReset($user->email);
				if (is_null($tmp)) {
					$tmp = $this->getPasswordReset($user->email);
				}
				$data["token"] = $tmp->token;
			}
			$data["user"] = $user;
		    $inlineEmail = new InlineEmail("notifications.auth.recover_password", $data);
		    $content  = $inlineEmail->convert();
		    $email = $user->email;

		    return \Mail::send(
		        "emails.inline_template", 
			    ["content" => $content], 
			   	function ($m) use ($user){
			        $m->to($user->email, $user->full_name)
			            ->subject(env("APP_NAME_BUSSINESS", "")." - Recuperación de Contraseña");
			   }
			);
		}
		return false;
	}
}