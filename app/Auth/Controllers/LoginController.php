<?php namespace App\Auth\Controllers;

use Validator,Redirect,Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Auth\Handlers\LoginInterface;
use App\Master\Handlers\UserInterface;
use App\User;
use DB;

class LoginController extends Controller
{
    protected $_loginI;

    public function __construct(
        LoginInterface $loginInterface
    )
    {
        $this->middleware("guest");
        $this->_loginI = $loginInterface;
    }
    public function show()
    {
        return view('login');
    }
    public function recoverPasswordView()
    {
        return view("auth.recover_password");
    }
    public function resetPasswordView(Request $request)
    {
        $explode = explode("/", \Request::path());
        $tokenUrl = isset($explode[1])? $explode[1] : "";
        $tokenEnabled = $this->_loginI->getPasswordReset($request->email);
        if (is_null($tokenEnabled)) {
            return redirect("login")->withErrors([
                "form" => trans("auth.reset_password.error.token_expired")
            ]);
        }
        return view("auth.reset_password");
    }
    public function sendEmailRecoverPassword(Request $request)
    {
        $messageSuccess = trans("auth.recover_password.success.message");

        $objUser = $this->_loginI->getByEmail(["email" => $request->email]);
        if (is_null($objUser)) {
            $objUser = $this->_loginI->getByUsername(["user_name" => $request->email]);
            if (is_null($objUser)) {
                return view("auth.recover_password")
                    ->withErrors([
                        "recover_error" => trans("auth.recover_password.error.not_found")
                ]);
            } else {
                $this->_loginI->sendEmailPasswordRecovery($objUser);
                return view("auth.recover_password")
                    ->withErrors([
                        "messageSuccess" => $messageSuccess
                ]);
            }
        } else {
            $this->_loginI->sendEmailPasswordRecovery($objUser);
            return view("auth.recover_password")
                    ->withErrors([
                        "messageSuccess" => $messageSuccess
                ]);
        }

    }
    public function resetPassword(Request $request)
    {
        $tokenPassword = isset($request->token)? $request->token : null;
        $email = isset($request->email)? $request->email : "";
        $password = isset($request->password)? $request->password : "";
        $passwordConfirmation = isset($request->password_confirmation)? $request->password_confirmation : "";
        if ($email == "") {
            return back()->withErrors([
                "email" => trans("auth.reset_password.error.email")
            ]);
        }
        $validator = Validator::make($request->all(), [
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return back()->withErrors([
                "password" => trans("auth.reset_password.error.password_min_size")
            ]);
        }
        if ($password != $passwordConfirmation) {
            return back()->withErrors([
                "password" => trans("auth.reset_password.error.password_not_equals")
            ]);
        }
        $objUser = $this->_loginI->getByEmail(["email" => $email]);
        if (is_null($objUser)) {
            $objUser = $this->_loginI->getByUsername(["user_name" => $email]);
            if (is_null($objUser)) {
                return back()->withErrors([
                    "email" => trans("auth.reset_password.error.user_not_found")
                ]);
            }
        }
        $tokenEnabled = $this->_loginI->getPasswordReset($email);
        if (is_null($tokenEnabled)) {
            return back()->withErrors([
                "form" => trans("auth.reset_password.error.token_expired")
            ]);
        }
        $objUser->password = \Hash::make($password);
        $objUser->save();

        DB::table("password_resets")->where("token", $tokenEnabled->token)->delete();
        return view("auth.login")
            ->withErrors([
                "form" => trans("auth.reset_password.error.success")
        ]);
    }
    public function authenticate(Request $request, UserInterface $userInterface)
    {
        $rememberToken = isset($request->remember_token) ? true : false;
        $objUser = $this->_loginI->getByEmail(["email" => $request->email]);
    
        if (is_null($objUser)) {
            $objUser = $this->_loginI->getByUsername(["user_name" => $request->email]);
            if (is_null($objUser)) {
                return response()->json([
                    "rst" => 2,
                    "msj" => "Recaptcha : " . trans("auth.login.error.not_found"),
                ]);
            }
        }
    
        try {
            $numIntentosMaximo = (int) $userInterface->getConfigUserByKey("quantity_login_attempts");
            $tiempoBloqueMaximo = (int) $userInterface->getConfigUserByKey("blocked_login_minutes");
            $validator = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
    
            if ($objUser->attempts_login >= $numIntentosMaximo) {
                $dateStart = new \DateTime($objUser->updated_at);
                $dateNow = new \DateTime(date("Y-m-d H:i:s"));
                $diff = $dateStart->diff($dateNow);
                if ((int) $diff->i > $tiempoBloqueMaximo) {
                    $objUser->attempts_login = 0;
                    $objUser->save();
    
                    if (!Auth::attempt($validator, $rememberToken)) {
                        $objUser->attempts_login++;
                        $objUser->save();
                        return response()->json([
                            "rst" => 2,
                            "msj" => "Credentials : Las credenciales son Incorrectas",
                        ]);
                    }
                    return response()->json([
                        "rst" => 1,
                        "login" => "OK",
                        "email" => $objUser->email, // Email incluido
                    ]);
                }
    
                return response()->json([
                    "rst" => 2,
                    "msj" => trans("auth.login.error.max_attempts") . " ($numIntentosMaximo). " . trans("auth.login.error.max_blocked_minutes") . " ($tiempoBloqueMaximo) ",
                ]);
            }
    
            if (Auth::attempt($validator, $rememberToken)) {
                $objUser->attempts_login = 0;
                $objUser->save();
                return response()->json([
                    "rst" => 1,
                    "login" => "OK",
                    "email" => $objUser->email, // Email incluido
                ]);
            } else {
                $credentials = [
                    "email" => $objUser->email,
                    "password" => $request->password,
                ];
                if (Auth::attempt($credentials, $rememberToken)) {
                    $objUser->attempts_login = 0;
                    $objUser->save();
                    return response()->json([
                        "rst" => 1,
                        "login" => "OK",
                        "email" => $objUser->email, // Email incluido
                    ]);
                }
    
                $objUser->attempts_login++;
                $objUser->save();
    
                return response()->json([
                    "rst" => 2,
                    "msj" => "Credentials : Las credenciales son Incorrectas",
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                "rst" => 2,
                "msj" => "Catch : " . $e->getMessage(),
            ]);
        }
    }


    
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return back();
    }
}
