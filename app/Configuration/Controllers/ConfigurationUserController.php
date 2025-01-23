<?php namespace App\Configuration\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Configuration\Models\Configuration;
use App\Configuration\Models\ConfigUser;
use DB;
use Auth;
class ConfigurationUserController extends Controller
{
    protected $_keyCache;

    public function __construct()
    {
        $this->_keyCache = \Config::get("configuration.keycache.user");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(
                ConfigUser::select("*")
            )->toJson();
        }
        return view("master.user.configuration.index");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($configurationId = "")
    {
        $configurationObj = ConfigUser::find($configurationId);
        
        return json_encode($configurationObj);
    }

    public function store(Request $request)
    {
        $msj = "";
        $configurationId = $request->has("configuration_id")? $request->configuration_id : null;
        $type = $request->has("type")? $request->type : "";
        $valueInput = $request->has("valueInput")? $request->valueInput : "";
        $valueSelect = $request->has("valueSelect")? $request->valueSelect : null;

        if ($type == "") {
            return response()->json(["rst" => "2", "msj" => "Debe elegir un Tipo"]);
        }
        switch((int)$type) {
            case 1:
                if ($valueInput == "") {
                    return response()->json(["rst" => 2, "msj" => "Debe colocar un Valor"]);
                }
                break;
            case 3:
                if (is_null($valueSelect)) {
                    return response()->json(["rst" => 2, "msj" => "Debe colocar un Valor"]);
                }
                break;
            default:
                break;
        }

        DB::beginTransaction();
        try {
            if (!is_null($configurationId)) {
                $configurationObj = ConfigUser::find($configurationId);
                $msj = "Configuración {$configurationObj->name} Actualizado";
            } else {
                $configurationObj = new ConfigUser;
                $msj = "Configuración {$request->name} Creado";
            }

            $configurationObj->name = $request->name;
            $configurationObj->key = $request->key;

            switch((int)$type) {
                case 1:
                    $configurationObj->value = $valueInput;
                    break;
                case 3:
                    $jsonValues = json_decode($request->jsonValues, true);
                    
                    foreach($jsonValues as $key => $value) {
                        if ((int)$valueSelect == (int)$value["id"]) {
                            $jsonValues[$key]["selected"] = true;
                        } else {
                            $jsonValues[$key]["selected"] = false;
                        }
                    }
                    $configurationObj->value = json_encode($jsonValues);
                    break;
                default:
                    break;
            }

            $configurationObj->status = $request->status;
            $configurationObj->save();

            DB::commit();
            \Cache::forget($this->_keyCache);
            
            return response()->json(["rst" => 1, "msj" => $msj]);
        } catch (\Exception $e) {
            DB::rollback();
            return response(["rst" => 2, "msj" => "Error BD : ".$e->getMessage()]);
        }
    }
}
