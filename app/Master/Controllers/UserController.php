<?php namespace App\Master\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use DB;
use Auth;
use App\Master\Models\Role;
use App\Master\Models\RoleUser;
use App\Master\Requests\UserRequest;
use App\Master\Handlers\UserInterface;
use App\Auth\Models\PasswordTrace;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(
                User::select([
                    "users.*",
                    DB::raw("IFNULL(rol.name, '') AS rol")
                ])
                ->leftJoin("role_user AS rolu", "rolu.user_id", "=", "users.id")
                ->leftJoin("roles AS rol", "rol.id", "=", "rolu.role_id")
                ->whereRaw("users.id <> ".Auth::user()->id)
            )->toJson();
        }
        $roles = Role::where("status", 1)->where("slug", "<>", "superadmin")->get();
        return view("master.user.index", compact("roles"));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($userId = "")
    {
        $userObj = User::find($userId);
        
        return json_encode($userObj);
    }

    public function store(
        UserRequest $request,
        UserInterface $userInterface
    ) {
        $msj = "";
        $userId = $request->has("user_id")? $request->user_id : null;
        $password = $request->has("password")? $request->password : "";
        $email = $request->email;
        $fromProfileUser = $request->has("fromProfileUser")? $request->fromProfileUser : 0;

        DB::beginTransaction();
        try {
            
            if (!is_null($userId)) {
                $userExistsByEmail = 
                    User::where("email", $email)
                        ->where("id", "<>", $userId)
                        ->first();
                if (!is_null($userExistsByEmail)) {
                    return response(["rst" => 2, "msj" => "Ya existe un Usuario con el Email que intentas registrar"]);
                }

                $user = User::find($userId);
                $msj = "Usuario {$user->name} Actualizado";
            } else {
                if ($password == "") {
                    return response(["rst" => 2, "msj" => "Debe registrar una contraseña para el nuevo Usuario"]);
                }
                $userExistsByEmail = User::where("email", $email)->first();
                if (!is_null($userExistsByEmail)) {
                    return response(["rst" => 2, "msj" => "Ya existe un Usuario con el Email que intentas registrar"]);
                }

                $user = new User;
                $msj = "Usuario {$request->name} Creado";
            }

            $user->name = $request->name;
            $user->email = $email;
            if ($password != '') {
                if (!is_null($userId)) {
                    if ((int)$fromProfileUser == 1) {
                        $flagUpdatePassword = (int)$userInterface->getConfigUserByKey("change_password_by_user");

                        if ($flagUpdatePassword == 0) {
                            return response()
                                ->json([
                                    "rst"   =>  2,
                                    "msj"   =>  "Revise la Configuración de Usuario, pues no está permitido que actualice contraseña"
                                ]);
                        }
                    }
                }
                $responseValidatePassword = 
                    $userInterface->validateRulesPassword($password);
                if ((int)$responseValidatePassword["rst"] == 2) {
                    return response()->json($responseValidatePassword);
                }
                $user->password = bcrypt($request->password);
                PasswordTrace::insert([
                    "email" =>  $user->email,
                    "password"  =>  $user->password
                ]);
            }
            $user->status = $request->status;
            $user->save();

            //actualiza los roles de ese usuario
            if ($request->has("role_id")) {
                RoleUser::where("user_id", $user->id)->delete();
                $objRole = new RoleUser;
                $objRole->role_id = $request->post("role_id");
                $objRole->user_id = $user->id;
                $objRole->save();
            }

            if ($request->has("attempts_login")) {
                $user->attempts_login =  $request->attempts_login;
                $user->save();
            }

            DB::commit();
            return response()->json(["rst" => 1, "msj" => $msj]);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["rst" => 2, "msj" => "Error BD : ".$e->getMessage()]);
        }
    }

    public function destroy($userId = "")
    {
        try {
            $user = User::find($userId);
            $name = $user->name;
            
            $user->delete();
            return response(["rst" => 1, "msj" => "Usuario {$name} Eliminado con Éxito"]);
        } catch (\Exception $e) {
            return response(["rst" => 2, "msj" => "Error en BD: ".$e->getTraceAsString()]);   
        }
    }

    public function accesIndex(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(
                User::select([
                    "users.*",
                    DB::raw("IFNULL(rol.name, '') AS rol")
                ])
                ->leftJoin("role_user AS rolu", "rolu.user_id", "=", "users.id")
                ->leftJoin("roles AS rol", "rol.id", "=", "rolu.role_id")
                ->whereRaw("users.id <> ".Auth::user()->id)
            )->toJson();
        }
        $roles = Role::where("status", 1)->where("slug", "<>", "superadmin")->get();
        return view("master.user.index", compact("roles"));
    }

    public function validateMinOldPassword(
        UserInterface $userInterface
    ) {
        $user = \Auth::user();
        $email = $user->email;

        $minDaysOldPassword = (int)$userInterface->getConfigUserByKey("password_min_days_expired");
        $maxDaysOldPassword = (int)$userInterface->getConfigUserByKey("password_max_days_expired");

        $passwordTrace = 
            PasswordTrace::where("email", $email)
                ->orderBy("created_at", "DESC")
                ->first();

        if (!is_null($passwordTrace)) {
            $currentDate = Carbon::now();
            $passwordTraceDate = new Carbon($passwordTrace->created_at);
            $daysDiff = $passwordTraceDate->diff($currentDate)->days;

            if ((int)$daysDiff > (int)$minDaysOldPassword && (int)$daysDiff > $maxDaysOldPassword) {
                return response()
                    ->json([
                        "rst" => 1,
                        "minTime" => $minDaysOldPassword,
                        "maxTime" => $maxDaysOldPassword,
                        "passwordTrace" =>  $passwordTrace,
                        "daysDiff"  =>  $daysDiff,
                        "currentDate"   =>  $currentDate
                    ]);
            }            
        }
        return response()
            ->json(["rst" => 2, "minTime" => $minDaysOldPassword]);
    }
}
